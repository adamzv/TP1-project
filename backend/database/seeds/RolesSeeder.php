<?php


class RolesSeeder extends DatabaseSeeder
{
    public function run()
    {
        /*
         * addinf roles in loop from array
         * author Dusan Angelovic as AngelovicD
         */
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
