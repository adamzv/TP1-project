<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Filter;
use Faker\Generator as Faker;

$factory->define(Filter::class, function (Faker $faker) {
    return [
        'name'=> $faker->word
    ];
});
