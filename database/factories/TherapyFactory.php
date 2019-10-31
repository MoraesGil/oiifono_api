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
        'description' => $faker->boolean(80) ? $faker->text($faker->numberBetween(20,100)) : ""
    ];
});

$factory->define(Pathology::class, function (Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text($faker->numberBetween(20,100)) : "",
        'cid' => $faker->word(3).$faker->numberBetween(1,999).$faker->word(3),
        'acting_area_id' => ActingArea::inRandomOrder()->first()->id
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
        'doctor_id' => Doctor::inRandomOrder()->first()->id,
        'hospitalization_id' => Hospitalization::inRandomOrder()->first()->id
    ];
});

/**
 * Trigger Objective therapy creation
 */
$factory->afterCreating(Therapy::class, function ($therapy, $faker) {
    $therapy->saveMany(factory(Objective::class,$faker->numberBetween(1, 4))->make());
});


/**
 * this define must be called by Therapy::class
 */
$factory->define(Objective::class, function (Faker $faker) {
    return [
        'pathology'=> Pathology::inRandomOrder()->first()->id,
        'strategy'=> Strategy::inRandomOrder()->first()->id,
        'repeat'=>$faker->numberBetween(1, 15),
        'minutes'=> $faker->boolean(80) ? 15 : 30,
        'description' => $faker->text(50)
    ];
});
