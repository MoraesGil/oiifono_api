<?php

use Faker\Generator as Faker;

use App\Entities\ActingArea;
use App\Entities\Hospitalization;
use App\Entities\Pathology;
use App\Entities\Strategy;
use App\Entities\Therapy;
use App\Entities\Objective;
use App\Entities\Doctor;

$factory->define(ActingArea::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text($faker->numberBetween(20, 100)) : ""
    ];
});

$factory->define(Pathology::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text($faker->numberBetween(20, 100)) : "",
        'cid' => $faker->word(3) . $faker->numberBetween(1, 999) . $faker->word(3),
        'acting_area_id' => ActingArea::inRandomOrder()->limit(1)->first()->id
    ];
});

$factory->define(Strategy::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : ""
    ];
});

$factory->define(Therapy::class, function (Faker $faker) {
    return [
        'description' => $faker->boolean(80) ? $faker->text(255) : "",
        'doctor_id' => Doctor::inRandomOrder()->limit(1)->first()->person_id,
        'hospitalization_id' => Hospitalization::inRandomOrder()->limit(1)->first()->id,
        'max_minutes' => $faker->boolean(80) ? 60 : 30,
        'times_week' => $faker->numberBetween(1, 6)
    ];
});

$factory->afterCreating(Therapy::class, function ($therapy, $faker) {
    $therapy->objectives()->saveMany(factory(Objective::class, $faker->numberBetween(1, 4))->make());
});

/**
 * this define must be called by Therapy::class
 */
$factory->define(Objective::class, function (Faker $faker) {
    return [
        'pathology_id' => Pathology::inRandomOrder()->limit(1)->first()->id,
        'strategy_id' => Strategy::inRandomOrder()->limit(1)->first()->id,
        'repeat' => $faker->numberBetween(1, 15),
        'minutes' => $faker->boolean(80) ? 15 : 30,
        'description' => $faker->text(50)
    ];
});
