<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use App\Models\Picture;
use Faker\Generator as Faker;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$factory->define(Picture::class, function (Faker $faker) {
    return [
        'link' => $faker->imageUrl(),
        'id_event' => Event::all()->unique()->random()->id,

    ];
});
