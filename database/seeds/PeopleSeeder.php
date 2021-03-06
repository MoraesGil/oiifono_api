<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

use App\Entities\Availability;
use App\Entities\Company;
use App\Entities\Doctor;
use App\Entities\Individual;
use App\Entities\Person;
use App\Entities\Hospitalization;
use App\Entities\HealthPlan;
use App\Entities\Therapy;
use App\Entities\User;


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

        $amountDoctors = 1;
        $amountHealthPlan = 10;
        $amountPatients = $amountDoctors * 50;

        $this->generateDoctors($amountDoctors);
        $this->generateHealthPlan($amountHealthPlan);
        $this->generatePatients($amountPatients);

        $this->generateDoctorAdmin();
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
                    $person = factory(Person::class)->state($genders[$individual->gender])->create();
                    $person->individual()->save($individual);

                    if ($this->faker->boolean(20))
                        $person->company()->save(factory(Company::class)->make());

                    for ($i = 0; $i <= 6; $i++) {
                        $availabilities = factory(Availability::class, 10)->make(['week_day' => $i]);
                        $person->availabilities()->saveMany($availabilities);
                    }

                    $person->doctor()->save($doctor);

                    $user = factory(User::class)->make();
                    $user->person_id = $person->id;
                    $user->save();
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
                    $person->company->healthPlans()->save(factory(HealthPlan::class)->make());
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
                    $person = factory(Person::class)->state($genders[$individual->gender])->create();
                    $person->individual()->save($individual);

                    //make a hospitalizations
                    if ($this->faker->boolean(80)) {
                        $person->individual->hospitalizations()->saveMany(factory(Hospitalization::class, 3)->state('discharged')->make());
                        $person->individual->hospitalizations->each(function (Hospitalization $hospitalization) {
                            factory(Therapy::class)->create([
                                'hospitalization_id' => $hospitalization->id,
                                'deleted_at' => $hospitalization->discharged
                            ]);
                        });
                    } //discharged

                    if ($this->faker->boolean(80)) {
                        $person->individual->hospitalizations()->save(factory(Hospitalization::class)->make());
                        $hospitalization_opened = $person->individual->hospitalizations()->whereNull('discharged')->first();

                        factory(Therapy::class)->create([
                            'hospitalization_id' => $hospitalization_opened->id,
                        ]);
                    }
                });
            });
    }

    protected function generateDoctorAdmin()
    {
        if(!User::whereEmail('teste@teste.com')->first())
        DB::transaction(function () {
            $doctor = factory(App\Entities\Doctor::class)->make();
            $individual = factory(Individual::class)->make();
            $genders = ['m' => 'male', 'f' => 'female'];
            $person = factory(Person::class)->state($genders[$individual->gender])->create();
            $person->individual()->save($individual);

            if ($this->faker->boolean(20))
                $person->company()->save(factory(Company::class)->make());
            $person->doctor()->save($doctor);

            for ($i = 1; $i <= 6; $i++) {
                $availabilities = [];
                $availabilities[] = factory(App\Entities\Availability::class)->make([
                    'week_day' => 1,
                    'start_at' => "07:00",
                    'end_at' =>  "12:00"
                ]);
                $availabilities[] = factory(App\Entities\Availability::class)->make([
                    'week_day' => 1,
                    'start_at' => "14:00",
                    'end_at' =>  "20:00"
                ]);

                $person->availabilities()->saveMany($availabilities);
            }
            // $user = factory(User::class)->make();
            $user = factory(User::class)->make([
                'email' => "teste@teste.com",
                'password' => Hash::make('teste321')
            ]);
            $user->person_id = $person->id;
            $user->save();
        });
    }
}
