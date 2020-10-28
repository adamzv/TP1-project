<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use App\Models\User;
use App\Models\Place;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Repeat;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {

    $cas = $faker->dateTimeBetween($startDate = '-3 years', $endDate = '+5 years');

    return [
        'name' => $faker->numerify('Event ##'),
        'desc' => $faker->boolean(50) ? $faker->text($maxNbChars = 500) : null,
        'room' => $faker->boolean(50) ? $faker->numerify('S ###') : null,
        'beginning' => $cas,
        'end' => $faker->dateTimeInInterval($startDate = $cas , $interval = '+ 8 days'),
        'id_user' => User::all()->random()->id,
        'id_place' => Place::all()->random()->id,
        'id_faculty' => Faculty::all()->random()->id,
        'id_department' => $faker->boolean(70) ? Department::all()->random()->id : null,
        'id_repeat' =>

    ];
});
