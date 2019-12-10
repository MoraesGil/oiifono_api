<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        // $this->call(CitiesTableSeederMain::class);
        $this->call(PathologiesTableSeeder::class);
        $this->call(TherapyBaseSeeder::class);
        $this->call(PeopleSeeder::class);
        $this->call(SchedulesSeeder::class);
        // $this->call(EvolutionsSeeder::class);

    }
}
