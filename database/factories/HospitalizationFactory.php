<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Hospitalization::class, function (Hospitalization $hospitalization, Doctor $doctor, Faker $faker) {
    return [
        'label' => $faker->text(45),
        'description' => $faker->boolean(80) ? $faker->text(255) : ""
    ];
});


$factory->afterMaking(App\Entities\Hospitalization::class, function ($hospitalization, $faker) {
    $post->save(factory(App\Comment::class)->make());
});
