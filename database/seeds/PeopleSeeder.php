<?php

use App\Entities\Availability;
use App\Entities\Company;
use App\Entities\Doctor;
use App\Entities\Individual;
use App\Entities\Person;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $maxDoctors = 22;
        $maxIndividuals = 100;
        $maxCompanies = 10;
        $availabilitiesPerDoctor = 7;
        $percentOfDeadPeople = 5;

        $doctorsToGenerate = 2;//max(0, $maxDoctors - Doctor::count());
        $individualsToGenerate = max(0, $maxIndividuals - Doctor::count());
        $companiesToGenerate = max(0, $maxCompanies - Doctor::count());

        $this->generateDoctors($doctorsToGenerate, $availabilitiesPerDoctor);
        $this->generateCompanies($companiesToGenerate);
        $this->generateIndividuals($individualsToGenerate, $percentOfDeadPeople, $faker);
    }

    protected function generateDoctors($amount, $availabilitiesPerDoctor)
    {
        DB::transaction(function () use ($amount, $availabilitiesPerDoctor) {

            factory(Doctor::class, $amount)
                ->make()
                ->each(function (Doctor $doctor) use ($availabilitiesPerDoctor) {
                    $person = factory(Person::class)->create();
                    $availabilities = factory(Availability::class, $availabilitiesPerDoctor)->make();

                    $person->availability()->saveMany($availabilities);
                    $person->doctor()->save($doctor);
                });
        });
    }

    protected function generateCompanies($amount)
    {
        DB::transaction(function () use ($amount) {
            factory(Company::class, $amount)
                ->make()
                ->each(function (Company $company) {
                    $person = factory(Person::class)->state('company')->create();
                    $person->company()->save($company);
                });
        });
    }

    protected function generateIndividuals($amount, $percentOfDeadPeople)
    {
        DB::transaction(function () use ($amount, $percentOfDeadPeople) {
            $dead = round($amount * $percentOfDeadPeople / 100);
            $alive = $amount - $dead;

            $bindIndividualToPerson = function (Individual $individual) {
                $genders = ['m' => 'male', 'f' => 'female'];

                $person = factory(Person::class)->state($genders[$individual->sex])->create();
                $person->individual()->save($individual);
            };

            factory(Individual::class, $dead)->state('dead')->make()->each($bindIndividualToPerson);
            factory(Individual::class, $alive)->make()->each($bindIndividualToPerson);
        });
    }
}
