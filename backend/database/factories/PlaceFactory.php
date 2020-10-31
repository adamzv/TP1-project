<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Place;
use App\Models\City;
use Faker\Provider\sk_SK\Address;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$faker = new Faker\Generator();
$factory->define(Place::class, function ($faker) {
    $faker->addProvider(new Faker\Provider\sk_SK\Address($faker));
    return [
        'name' => $faker->streetAddress(),
        'id_city' => City::all()->random()->id,
    ];
});
