<?php

use Faker\Generator as Faker;
use App\Entities\Hospitalization;
use App\Entities\HealthPlan;
use App\Entities\Doctor;

$factory->state(Hospitalization::class, 'discharged', function (Faker $faker) {

    $hospitalization_date = $faker->dateTimeThisYear();
    $discharge = $faker->dateTimeBetween($hospitalization_date, '+' . $faker->numberBetween(0, 120) . ' days');

    return
        [
            'created_at' => $hospitalization_date,
            'discharged' => $discharge,
            'discharged_by' => $faker->text(45),
            'discharged_doctor_id' => Doctor::inRandomOrder()->first()->person_id,
        ];
});

$factory->define(Hospitalization::class, function (Faker $faker) {
    return [
        'health_plan_id' => $faker->boolean(80) ? HealthPlan::inRandomOrder()->first()->id : null,
        'created_at' => $faker->dateTimeThisYear()
    ];
});
