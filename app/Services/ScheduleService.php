<?php

namespace App\Services;

use App\Entities\Availability;
use App\Entities\Doctor;
use App\Entities\Objective;
use App\Entities\Therapy;
use App\Entities\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ScheduleService
{
    public function storeSchedule(Schedule $schedule)
    {
        if ($this->hasConflictingSchedules($schedule, $schedule->start_at, $schedule->end_at)) return null;

        $schedule->save();
        return $schedule;
    }

    public function updateSchedule(Schedule $schedule, $newStartAt, $newEndAt)
    {
        if ($this->hasConflictingSchedules($schedule, $newStartAt, $newEndAt)) return null;

        $schedule->update([
            'start_at' => Carbon::parse($newStartAt),
            'end_at' => Carbon::parse($newEndAt)
        ]);

        return $schedule;
    }

    /**
     * Checks if exists a conflict with a schdule in the given timerange.
     * 
     * @param Schedule $schedule The schedule which will be checked.
     * @param Carbon $startAt The start time of the timerange.
     * @param Carbon $endAt the end time of the timerange.
     */
    protected function hasConflictingSchedules(Schedule $schedule, $startAt, $endAt)
    {
        return !!Schedule::query()
            ->where(function (Builder $query) use ($schedule) {
                $query->where('person_id', $schedule->person_id)
                    ->orWhere('doctor_id', $schedule->doctor_id);
            })->where(function (Builder $query) use ($startAt, $endAt) {
                $query->whereBetween('start_at', [$startAt, $endAt])
                    ->orWhereBetween('end_at', [$startAt, $endAt]);
            })->where('id', '!=', $schedule->id)
            ->first();
    }

    /**
     * Creates the schedules needed to complete a therapy plan.
     * 
     * @param Collection $daysOfWeek Collection with the new schedules weekday(key) and start time(value).
     */
    public function schedule(Therapy $therapy, Doctor $doctor, Collection $daysOfWeek)
    {
        $therapyMaxSessionLength = $therapy->max_minutes;
        $patient = $therapy->hospitalization->individual;

        if ($this->hasAvailabilityConflict($doctor, $daysOfWeek, $therapy->max_minutes))
            return null;

        $patientSchedules = Schedule::getPatientFutureSchedules($patient->person_id);

        $schedulesRemaining = count($this->createSchedulesDurationsForObjectives(
            $this->getRemainingObjectives($therapy),
            $therapyMaxSessionLength,
            $patientSchedules
        ));

        $existingSchedules = $patientSchedules->merge(Schedule::getDoctorFutureSchedules($doctor->person_id));

        $newSchedules = $this->createSchedules(
            $existingSchedules,
            $daysOfWeek,
            $schedulesRemaining,
            $therapy->max_minutes,
            $doctor->id,
            $patient->person_id
        );

        return $doctor->schedules()->createMany($newSchedules->toArray());
    }

    /**
     * Computes the best time for a schedule start_at for a given therapy and doctor.
     */
    public function getBestSchedules(Therapy $therapy, Doctor $doctor)
    {
        $availabilities = $doctor->person->availabilities;
        $patientSchedules = Schedule::getPatientFutureSchedules($therapy->hospitalization->person_id);
        $futureSchedules = Schedule::getDoctorFutureSchedules($doctor->person_id)
            ->merge($patientSchedules);

        $schedulesRemaining = count($this->createSchedulesDurationsForObjectives(
            $this->getRemainingObjectives($therapy),
            $therapy->max_minutes,
            $patientSchedules
        ));

        return $this->computeBestSchedules(
            $availabilities,
            $futureSchedules,
            $schedulesRemaining,
            $therapy->max_minutes
        );
    }

    /**
     * Get the therapy's remaining schedules.
     */
    protected function getRemainingObjectives(Therapy $therapy)
    {
        return Objective::query()
            ->where(['therapy_id' => $therapy->id])
            ->with(['appointments'])
            ->get()
            ->filter(function (Objective $objective) {
                return $objective->getRepetitionsRemainingAttribute() > 0;
            })->sortBy('repetitions_remaining');
    }

    /**
     * Computes how many schedules are needed to complete a collection of objectives,
     * and how long they have (atleast) to be.
     * 
     * @param Collection $objectives Collection of objectives to fulfill.
     * @param int $therapyMaxSessionLength Max length in minutes for a session.
     * @param Collection $patientSchedules Patient's Schedules.
     */
    protected function createSchedulesDurationsForObjectives(Collection $objectives, $therapyMaxSessionLength, Collection $patientSchedules)
    {
        $schedules = new Collection();
        $objectives->each(function (Objective $objective) use (&$schedules, $therapyMaxSessionLength) {
            $repetitionsRemaining = $objective->repetitions_remaining;

            foreach ($schedules as $index => $schedule) {
                if ($schedule + $objective->minutes <= $therapyMaxSessionLength) {
                    $schedules[$index] += $objective->minutes;
                    $repetitionsRemaining--;
                }
            }
            $schedules = $schedules->pad($schedules->count() + $repetitionsRemaining, $objective->minutes);
        });
        return $schedules->slice(0, max($schedules->count(), $patientSchedules->count()));
    }

    /**
     * Computes the best time for a schedule start_at for a collection of availabilities.
     *
     * @param Collection $availability Doctor's availabilities.
     * @param Collection $schedules Doctor's and Patient's shedules.
     * @param int $sessions How many sessions to schedule.
     * @param int $sessionLength Session length in minutes.
     */
    protected function computeBestSchedules(Collection $availabilities, Collection $futureSchedules, $sessions, $sessionLength)
    {
        $bestSchedules = new Collection();
        $futureSchedulesPerWeekday = $futureSchedules->groupBy(function (Schedule $schedule) {
            return $schedule->start_at->dayOfWeek;
        });

        foreach ($availabilities as $availability) {
            if (!$bestSchedules->has($availability->week_day)) {
                $bestSchedules->put($availability->week_day, collect());
            }

            $bestSchedules->put(
                $availability->week_day,
                $this->computeBestSchedulesForAvailability(
                    $availability,
                    $futureSchedulesPerWeekday->get($availability->week_day, collect()),
                    $sessions,
                    $sessionLength,
                )->merge($bestSchedules->get($availability->week_day))
            );
        }
        return $bestSchedules;
    }

    /**
     * Computes the best time for a schedule start_at for a given availability.
     * 
     * @param Availability $availability
     * @param Collection $schedules Doctor's and Patient's shedules.
     * @param int $sessions How many sessions to schedule.
     * @param int $sessionLength Session length in minutes.
     */
    protected function computeBestSchedulesForAvailability(Availability $availability, Collection $schedules, $sessions, $sessionLength)
    {
        $bestSchedules = new Collection();

        $daysToAvailabilityWeekDay = ($availability->week_day -  Carbon::today()->dayOfWeek + 7) % 7;

        $scheduleStartAt = Carbon::parse($availability->start_at)->addDays($daysToAvailabilityWeekDay);
        $scheduleEndAt = $scheduleStartAt->copy()->addMinutes($sessionLength);

        $availabilityEndAt = Carbon::parse($availability->end_at)->addDays($daysToAvailabilityWeekDay);

        while ($scheduleEndAt->lessThanOrEqualTo($availabilityEndAt)) {
            $necessarySchedules = $this->createSchedules($schedules, collect([$availability->week_day => $scheduleStartAt->format("H:i:s")]), $sessions, $sessionLength);
            $numberOfWeeks = Carbon::today()->diffInWeeks($necessarySchedules->last()['start_at']);

            $bestSchedules->push(['start_at' => $scheduleStartAt->format('H:i'), 'weeks' => $numberOfWeeks]);

            $scheduleStartAt->addMinutes($sessionLength);
            $scheduleEndAt->addMinutes($sessionLength);
        }

        return $bestSchedules;
    }

    /**
     * Defines new schedules for a given doctor and patient.
     * 
     * @param Collection $existingSchedules Doctor's and Patient's shedules.
     * @param Collection $daysOfWeek Collection with the new schedules weekday(key) and start time(value).
     * @param int $sessions How many sessions to schedule.
     * @param int $sessionLength Session length in minutes.
     */
    protected function createSchedules(Collection $existingSchedules, Collection $daysOfWeek, $sessions, $sessionLength, $doctorId = null, $personId = null)
    {
        $schedules = new Collection();
        $daysOfWeek = $daysOfWeek->map(function ($startAt, $dayOfWeek) {
            $daysToWeekDay = ($dayOfWeek -  Carbon::today()->dayOfWeek + 7) % 7;
            $scheduleStartAt = Carbon::parse($startAt)->addDays($daysToWeekDay);
            if ($scheduleStartAt->isPast()) $scheduleStartAt->addWeek(1);
            return $scheduleStartAt;
        })->sort();

        while ($schedules->count() < $sessions) {
            $daysOfWeek->map(function (Carbon $startAt) use ($sessionLength, $schedules, $existingSchedules, $doctorId, $personId) {
                $scheduleStartAt = $startAt->copy();
                $scheduleEndAt = $startAt->copy()->addMinutes($sessionLength);

                $conflictingSchedules = $existingSchedules->filter(function (Schedule $schedule) use ($scheduleStartAt, $scheduleEndAt) {
                    return $this->doesIntervalConflictsWithSchedule($schedule, $scheduleStartAt, $scheduleEndAt);
                });

                if ($conflictingSchedules->count() == 0) $schedules->push([
                    'start_at' => $scheduleStartAt,
                    'end_at' => $scheduleEndAt,
                    'doctor_id' => $doctorId,
                    'person_id' => $personId
                ]);

                return $startAt->addWeek(1);
            });
        }
        return $schedules->splice(0, $sessions);
    }

    /**
     * Checks if a given timerange conflicts with a schedule.
     */
    protected function doesIntervalConflictsWithSchedule(Schedule $schedule, Carbon $startAt, Carbon $endAt)
    {
        return $startAt->between($schedule->start_at, $schedule->end_at)
            || $endAt->between($schedule->start_at, $schedule->end_at);
    }

    /**
     * Checks if exists conflicts with the doctor's availabilities and the new schedules time and weekday
     */
    protected function hasAvailabilityConflict(Doctor $doctor, Collection $daysOfWeek, $sessionLength)
    {
        $query = Availability::query()
            ->where('person_id', $doctor->getKey())
            ->where(function (Builder $query) use ($sessionLength, $daysOfWeek) {
                $daysOfWeek->each(function ($start_at, $week_day) use ($sessionLength, $query) {
                    $end_at = Carbon::parse($start_at)->addMinutes($sessionLength)->format('H:i');

                    $query->orWhere(function (Builder $query) use ($start_at, $end_at, $week_day) {
                        $query->where('start_at', '<=', $start_at)
                            ->where('end_at', '>=', $end_at)
                            ->where('week_day', $week_day);
                    });
                });
            });

        return $query->get()->pluck('week_day')->unique()->count() == count($daysOfWeek);
    }
}
