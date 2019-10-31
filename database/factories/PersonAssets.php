<?php

use Faker\Generator as Faker;
use App\Entities\Address;
use App\Entities\Contact;
use App\Entities\City;
use App\Entities\HealthPlan;

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
        'address' => $faker->address,
        'district' => $faker->words(4),
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
        'label' =>  $faker->word()
    ];
});
