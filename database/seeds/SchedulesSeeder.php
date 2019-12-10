<?php

use App\Entities\Person;
use App\Entities\Schedule;
use Illuminate\Database\Seeder;

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

        foreach (Person::has('doctor')->get() as $doctor) {
            for ($i = 0; $i < $numSchedules; $i++) {
                $schedule = factory(Schedule::class)->make();
                $schedule->doctor_id = $doctor->id;
                $schedule->person_id = Person::patients()->inRandomOrder()->limit(1)->first();
                $schedule->save();
            }
        }
    }
}
