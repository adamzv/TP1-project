<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Role;
use Faker\Generator as Faker;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
$factory->define(User::class, function (Faker $faker) {
    $datum = $faker->dateTime($max = 'now');
    return [
        'name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'surname' => $faker->lastName,
        'password' => $faker->password,
        'email_verified_at' => $faker->boolean(50) ? $faker->dateTimeBetween($startDate = $datum, $endDate = 'now') : null,
        'id_role' => Role::all()->random()->id,
        'created_at' => $datum
    ];
});
