<?php

use Illuminate\Database\Seeder;

/**
 * Class usersSeeder
 *
 * @author klukak
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 10)->create();
    }
}
