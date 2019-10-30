<?php

use Faker\Generator as Faker;

use App\Entities\ActingArea;
use App\Entities\Hospitalization;
use App\Entities\Pathology;
use App\Entities\Strategy;
use App\Entities\Therapy;
use App\Entities\Objective;



$factory->define(ActingArea::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : ""
    ];
});

$factory->define(Pathology::class, function (Faker $faker, ActingArea $actingArea = null) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : "",
        'cid' => $faker->boolean(80) ? $faker->text(5) : "",
        'acting_area' => $actingArea != null ? $actingArea->id : null
    ];
});

$factory->define(Strategy::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : ""
    ];
});

$factory->define(Therapy::class, function (Hospitalization $hospitalization, Doctor $doctor, Faker $faker) {
    return [
        'description' => $faker->boolean(80) ? $faker->text(255) : "",
        'doctor_id' => $doctor->id,
        'hospitalization_id' =>$hospitalization->id
    ];
});

$factory->define(Objective::class, function (Faker $faker, ) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : ""
    ];
});
