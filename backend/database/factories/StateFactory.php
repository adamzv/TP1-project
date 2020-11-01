<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\State;
use Faker\Generator as Faker;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$factory->define(State::class, function (Faker $faker) {


    return [

        'name' => 'Slovensko',

    ];
});
