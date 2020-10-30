<?php


class CategoriesSeeder extends DatabaseSeeder
{
    public function run(){
        //vlozenie categories
        $categories_array = array('zábava a šport',
            'konferencie',
            'erazmus');
        for ($i = 1; $i <= (sizeof($categories_array)); $i++) {
            DB::table('categories')->insert([
                'name' => $categories_array[$i - 1]]);
        }
    }
}
