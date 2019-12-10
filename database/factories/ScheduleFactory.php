<?php

use Faker\Generator as Faker;
use App\Entities\Schedule;
use Illuminate\Support\Carbon;

$factory->define(Schedule::class, function (Faker $faker) {
    $startAt = Carbon::today()->addDays($faker->numberBetween(0, 30))->setTime($faker->numberBetween(0, 22), 0);
    $endAt = $startAt->copy()->addHour(1);

    return [
        'start_at' => $startAt->toDateTimeString(),
        'end_at' => $endAt->toDateTimeString(),
        'confirmed' => $this->faker->boolean(),
        'absence_by' => $this->faker->boolean(90) ? null : $faker->text(20)
    ];
});
