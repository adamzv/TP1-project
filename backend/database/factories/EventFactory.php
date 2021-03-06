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
        'attendance_limit' => $faker->boolean(50) ? $faker->numberBetween($min = 20, $max = 300) : -1,
        'lecturer' => $faker->name,
        'id_user' => User::all()->random()->id,
        'id_place' => Place::all()->random()->id,
        'id_faculty' => Faculty::all()->random()->id,
        'id_department' => $faker->boolean(50) ? Department::all()->random()->id : null,



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
        $test = DB::table('category_event')->where('event_id', '=', $ev->id)->where('category_id', '=', $idcat)->first();


        if ($test === null) {

            DB::table('category_event')->insert(
                [
                    'event_id' => $ev->id,
                    'category_id' => $idcat,
                ]);
        };
    };

    /**
     *  Pivot table for events and users
     *  One user can be on many events
     **/
    for ($i = 1; $i <= $user; $i++) {
        $iduser = \App\Models\User::all()->random()->id;
        $test = DB::table('event_user')->where('user_id', '=', $iduser)->where('event_id', '=', $ev->id)->first();


        if ($test === null && $value === 1) {

            DB::table('event_user')->insert(
                [
                    'user_id' => $iduser,
                    'event_id' => $ev->id,
                ]);
        };
    };


});

