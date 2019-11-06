<?php

use Faker\Generator as Faker;
use App\Entities\Schedule;

$factory->define(Schedule::class, function (Faker $faker) {

    return [
        'label'=> $faker->text(50),
        'type'=>null,
        'start_at'=>null,
        'end_at'=>null,
        'therapy_id'=>null,
        'parent_id'=>null,
        'absence_by'=>$this->faker->boolean(90) ? null : $faker->text(20)
    ];
});
