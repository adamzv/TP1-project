<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use App\Models\State;
use Faker\Provider\sk_SK\Address;

$faker = new Faker\Generator();

$factory->define(City::class, function ($faker) {
    $faker->addProvider(new Faker\Provider\sk_SK\Address($faker));

    return [
       'name' => $faker->city(),
        'id_state' => State::all()->random()->id,
        ];

});
