<?php


class CategoriesSeeder extends DatabaseSeeder
{
    /*
     * adding catefories in loop from array
     * author Dusan Angelovic as AngelovicD
     */
    public function run(){

        $categories_array = array('zábava a šport',
            'konferencie',
            'erazmus');
        for ($i = 1; $i <= (sizeof($categories_array)); $i++) {
            DB::table('categories')->insert([
                'name' => $categories_array[$i - 1]]);
        }
    }
}
