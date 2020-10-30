<?php


class CategoriesSeeder extends DatabaseSeeder
{
    public function run(){
        //vlozenie categories
        DB::table('categories')->insert([
            'name'=>'zábava a šport',
            'name'=>'konferencie',
            'name'=>'erazmus',

        ]);
    }
}
