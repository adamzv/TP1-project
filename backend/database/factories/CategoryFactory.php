<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['FPV', 'Katedra informatiky', 'PP']),
    ];
});
