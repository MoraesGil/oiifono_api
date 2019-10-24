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
        // $this->call(StatesTableSeeder::class);
        // $this->call(CitiesTableSeeder::class);

        // $this->call(PathologiesTableSeeder::class);
        // $this->call(ActingAreasTableSeeder::class);

        $this->call(PatientsSeeder::class);
    }
}
