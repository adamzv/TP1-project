<?php


class RolesSeeder extends DatabaseSeeder
{
    public function run(){
        //vlozenie roli (ne tote co su na nich grule)
        DB::table('roles')->insert([
            'type'=>'admin',
            'type'=>'moderator',
            'type'=>'pouzivatel',
            'type'=>'host'
        ]);
    }
}
