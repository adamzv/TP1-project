<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Repeat;
use Faker\Generator as Faker;

$factory->define(Repeat::class, function (Faker $faker) {
    return [
        'repeatUnit' => $faker->name,
        'repeatNumber' => $faker->randomDigit,
        'repeatUntil' => $faker->dateTimeInInterval($startDate = '-3 years', $interval = '+ 3 years', $timezone = null),
    ];
});
