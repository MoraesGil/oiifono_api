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
        $this->call(TherapyBaseSeeder::class);
        $this->call(PeopleSeeder::class);
    }
}
