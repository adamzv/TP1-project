<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place;
use App\Models\City;
use Faker\Generator;
use Faker\Provider\sk_SK\Address;
$faker = new Faker\Generator();

$factory->define(Place::class, function ($faker) {
    $faker->addProvider(new Faker\Provider\en_US\Address($faker));
    return [
        'name' => $faker->word(),
        'id_city' => City::all()->random()->id,
    ];
});
