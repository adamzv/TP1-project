<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Repeat;
use Faker\Generator as Faker;

$factory->define(Repeat::class, function (Faker $faker) {
    return [
        'repeatUnit' => $faker->randomElement(['rok', 'mesiac', 'den']),
        'repeatNumber' => $faker->randomDigitNot(0),
        'repeatUntil' => $faker->dateTimeInInterval($startDate = '-3 years', $interval = '+ 3 years', $timezone = null),
    ];
});
