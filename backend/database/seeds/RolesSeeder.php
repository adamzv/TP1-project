<?php

/**
 * Class RolesSeeder
 *
 * @author angelovicd
 */
class RolesSeeder extends DatabaseSeeder
{

    public function run()
    {

        // adding roles in loop from array
        $roles_array = array('admin',
            'moderator',
            'pouzivatel',
            'host');
        for ($i = 1; $i <= (sizeof($roles_array)); $i++) {
            DB::table('roles')->insert([
                'type' => $roles_array[$i - 1]]);
        }
    }
}
