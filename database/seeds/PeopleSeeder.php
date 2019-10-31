<?php

use App\Entities\Availability;
use App\Entities\Company;
use App\Entities\Doctor;
use App\Entities\Individual;
use App\Entities\Person;
use App\Entities\Hospitalization;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{

    private $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();

        $amountDoctors = 30;
        $amountHealthPlan = 5;
        $amountPatients = 500;

        $this->generateDoctors($amountDoctors);
        // $this->generateHealthPlan($amountHealthPlan);
        // $this->generatePatients($amountPatients);
    }

    protected function generateDoctors($amount)
    {
        // Person::with(["doctor","individual","company"])->whereHas('company')->get()
        factory(Doctor::class, $amount)
            ->make()
            ->each(function (Doctor $doctor) {
                DB::transaction(function () use ($doctor) {
                    $individual = factory(Individual::class)->make();
                    $genders = ['m' => 'male', 'f' => 'female'];
                    $person = factory(Person::class)->state($genders[$individual->sex])->create();
                    $person->individual()->save($individual);

                    if ($this->faker->boolean(20))
                        $person->company()->save(factory(Company::class)->make());

                    $availabilities = factory(Availability::class, 10)->make();
                    $person->availability()->saveMany($availabilities);

                    $person->doctor()->save($doctor);
                });
            });
    }

    protected function generateHealthPlan($amount)
    {
        factory(Company::class, $amount)
            ->make()
            ->each(function (Company $company) {
                DB::transaction(function () use ($company) {
                    $person = factory(Person::class)->state('company')->create();
                    $person->company()->save($company);
                    $person->company->healthPlans()->saveMany(factory(HealthPlan::class)->make());
                });
            });
    }

    protected function generatePatients($amount)
    {
        factory(Individual::class, $amount)
            ->make()
            ->each(function (Individual $individual) {
                DB::transaction(function () use ($individual) {
                    $genders = ['m' => 'male', 'f' => 'female'];
                    $person = factory(Person::class)->state($genders[$individual->sex])->create();
                    $person->individual()->save($individual);

                    if ($this->faker->boolean(80)){
                        $person->individual->hospitalizations()->saveMany(factory(Hospitalization::class,3)->state('discharged')->make());
                        $person->individual->hospitalizations()->saveMany(factory(Hospitalization::class,1)->make());
                    }
                });
            });
    }
}
