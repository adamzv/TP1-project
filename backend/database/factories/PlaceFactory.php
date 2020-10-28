<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place;
use App\Models\City;
use Faker\Generator as Faker;
use Faker\Provider\sk_SK\Address;

$factory->define(Place::class, function (Faker $faker) {
    $faker->addProvider(new Faker\Provider\sk_SK\Address($faker));
    return [
        'name' => $faker->street_address(),
        'id_city' => City::all()->random()->id,
    ];
});
