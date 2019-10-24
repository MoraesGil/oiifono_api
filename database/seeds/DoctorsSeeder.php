<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Entities\Person;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generateAmount = 100;
        $faker = Factory::create();

        while (Patient::count() <= $generateAmount) {
            DB::beginTransaction();
            try {
                $gender = $faker->boolean(50) ? 'male' : 'female';
                $pes = Person::create(["name" => $faker->name($gender), "nickname" => $faker->boolean(30) ? $faker->firstName($gender) : null]);
                $pes->individual()->create(["birth_date" => $faker->dateTimeThisCentury->format('Y-m-d'), "rg" => $faker->numerify('#########'), "cpf" => $faker->numerify('###########'), "sex" => $gender == 'male' ? 'm' : 'f']);
                $pes->individual->patient()->create();
                DB::commit();
            } catch (Exception $e) {
                dump($e->getMessage());
                dump('rollback');
                DB::rollback();
            }
        }
    }
}
