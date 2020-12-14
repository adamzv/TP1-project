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
        //factory(\App\Models\User::class, 10)->create();

        $users = \App\Models\Role::all()->pluck('id')->toArray();

        /**
         * Creating seeder for every role
         */
        for ($i = 1; $i < (sizeof($users)); $i++) {
            DB::table('users')->insert([

                'name' => 'Janko',
                'email' => 'janko' . $i . '@gmail.com',
                'surname' => 'Mrkvicka',
                'password' => bcrypt('test123'),
                'email_verified_at' => now(),
                'id_role' => $users[$i - 1],
                'created_at' => now(),]);
        }

    }
}