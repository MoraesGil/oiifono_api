<?php

use App\Entities\Address;
use App\Entities\Availability;
use App\Entities\Company;
use App\Entities\Contact;
use App\Entities\Doctor;
use App\Entities\Individual;
use App\Entities\Person;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Person::class, function (Faker $faker, $param) {
  return [
    'name' => $faker->name()
  ];
});

$factory->state(Person::class, 'company', function (Faker $faker) {
  return [
    'name' => $faker->company,
  ];
});

$factory->state(Person::class, 'male', function (Faker $faker) {
  return [
    'name' => $faker->name('male'),
    'picture' => "https://randomuser.me/api/portraits/med/men/".$faker->numberBetween(1, 90).".jpg"
  ];
});

$factory->state(Person::class, 'female', function (Faker $faker) {
  return [
    'name' => $faker->name('female'),
    'picture'=> "https://randomuser.me/api/portraits/med/women/".$faker->numberBetween(1, 90).".jpg"
  ];
});

$factory->afterCreating(Person::class, function ($person,$faker) {
  $person->address()->save(factory(Address::class)->make());
  $person->contacts()->saveMany(factory(Contact::class,4)->make());
});

$factory->define(Availability::class, function (Faker $faker) {
  $time1 = $faker->time();
  $time2 = $faker->time();
  return [
    'dayOfWeek' => $faker->randomNumber() % 7,
    'start_at' => min($time1, $time2),
    'end_at' => max($time1, $time2)
  ];
});

$factory->define(Individual::class, function (Faker $faker) {
  $disabilities = ['Cego', 'Surdo', 'Mudo', 'Síndrome de Down'];

  return [
    'birthdate' => Carbon::createFromTimestamp($faker->dateTimeBetween('-80 years', '-1 year')->getTimestamp()),
    'sex' => $faker->boolean() ? 'm' : 'f',
    'cpf' => $faker->numerify('###########'),
    'rg' => $faker->numerify('#########'),
    'disabilities' => $faker->boolean(40) ? $faker->randomElement($disabilities) : null
  ];
});

$factory->state(Individual::class, 'dead', function (Faker $faker) {
  return [
    'deathdate' => Carbon::createFromTimestamp($faker->dateTimeThisYear()->getTimestamp())
  ];
});

$factory->define(Company::class, function (Faker $faker) {
  return [
    'cnpj' => $faker->numerify('##############')
  ];
});

$factory->define(Doctor::class, function (Faker $faker) {
  return [
    'register' => $faker->numerify('#####')
  ];
});
