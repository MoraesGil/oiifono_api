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
            'create_at' => $hospitalization_date,
            'discharge' => $discharge,
            'discharge_by' => $faker->text(45),
            'discharge_doctor_id' => Doctor::inRandomOrder()->first(),
        ];
});

$factory->define(Hospitalization::class, function (Faker $faker) {
    return [
        'health_plan_id' => $faker->boolean(75) ? HealthPlan::inRandomOrder()->first() : null,
        'create_at' => $faker->dateTimeThisYear()
    ];
});
