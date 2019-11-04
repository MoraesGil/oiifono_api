<?php

use Faker\Generator as Faker;
use App\Entities\Address;
use App\Entities\Contact;
use App\Entities\City;
use App\Entities\HealthPlan;
use App\Entities\Availability;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Address::class, function (Faker $faker) {
    return [
        'city_id' => City::inRandomOrder()->first(),
        'address' => $faker->streetName.", ".$faker->numberBetween(1, 1000),
        'district' => $faker->word(4,true),
        'zipcode' => $faker->postcode,
        'complements' => $faker->text(20)
    ];
});


$factory->define(Contact::class, function (Faker $faker) {
    //0  email, 1 phone
    $type = $faker->numberBetween(0, 1);
    return [
        'description' => $type ? $faker->email : $faker->numerify('###########'),
        'type' => $type,
    ];
});

$factory->define(HealthPlan::class, function (Faker $faker) {
    return [
        'label' =>  $faker->text(40)
    ];
});

$factory->define(Availability::class, function (Faker $faker) {
    $max = 20;
    $min = 7;

    $start =  Carbon::now()->startOfDay()->addHour($faker->numberBetween($min, $max))->addMinutes($faker->randomElement([0,15,30,45]));
    $end = $start->addHour($faker->numberBetween(7, 20))->addMinutes($faker->randomElement([0,15,30,45]));

    return [
        'dayOfWeek' => $faker->randomNumber() % 7,
        'start_at' => $start->toTimeString(),
        'end_at' => $end->toTimeString()
    ];
});

