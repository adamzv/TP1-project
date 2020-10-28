<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Picture;
use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Picture::class, function (Faker $faker) {
    return [
        'link' => $faker->imageUrl(),
        'id_event' => Event::all()->unique()->random()->id,

    ];
});
