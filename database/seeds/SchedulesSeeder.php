<?php

use App\Entities\Person;
use App\Entities\Schedule;
use Illuminate\Database\Seeder;;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numSchedules = 100;
        $doctors = Person::query()->has('doctor')->get();
        $patients = Person::query()->has('individual')->get();


        for ($i = 0; $i < $numSchedules; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();

            $schedule = factory(Schedule::class)->make();

            $schedule->doctor_id = $doctor->id;
            $schedule->person_id = $patient->id;
            $schedule->save();
        }
    }
}
