<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Place;
use App\Models\User;
use Faker\Generator as Faker;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$factory->define(Event::class, function (Faker $faker) {

    $cas = $faker->dateTimeBetween($startDate = '-3 years', $endDate = '+5 years');


    return [
        'name' => $faker->numerify('Event ##'),
        'desc' => $faker->boolean(50) ? $faker->text($maxNbChars = 500) : null,
        'room' => $faker->boolean(50) ? $faker->numerify('S-###') : null,
        'beginning' => $cas,
        'end' => $faker->dateTimeInInterval($startDate = $cas, $interval = '+ 8 days'),
        'attendance_limit' => $faker->boolean(50) ? $faker->numberBetween($min = 20, $max = 300) : null,
        'id_user' => User::all()->random()->id,
        'id_place' => Place::all()->random()->id,
        'id_faculty' => Faculty::all()->random()->id,
        'id_department' => $faker->boolean(50) ? Department::all()->random()->id : null,
        'id_repeat' => $faker->boolean(50) ? factory(App\Models\Repeat::class)->create(['repeatUntil' => $faker->dateTimeBetween($startDate = $cas, $endDate = '+5 years')])->id : null,


    ];

    /** Creating pivot tables:**/

})->afterCreating(\App\Models\Event::class, function (\App\Models\Event $ev, $faker) {
    $value = rand(0, 1);
    $cislo = rand(1, 10);
    $user = rand(1, 10);

    /** Pivot table for event relate to category
     *  One event has many categories
     **/
    for ($i = 0; $i <= $cislo; $i++) {
        $idcat = \App\Models\Category::all()->random()->id;
        $test = DB::table('category_event')->where('id_event', '=', $ev->id)->where('id_category', '=', $idcat)->first();


        if ($test === null) {

            DB::table('category_event')->insert(
                [
                    'id_event' => $ev->id,
                    'id_category' => $idcat,
                ]);
        };
    };

    /**
     *  Pivot table for events and users
     *  One user can be on many events
     **/
    for ($i = 1; $i <= $user; $i++) {
        $iduser = \App\Models\User::all()->random()->id;
        $test = DB::table('event_user')->where('id_user', '=', $iduser)->where('id_event', '=', $ev->id)->first();


        if ($test === null && $value === 1) {

            DB::table('event_user')->insert(
                [
                    'id_user' => $iduser,
                    'id_event' => $ev->id,
                ]);
        };
    };


});

