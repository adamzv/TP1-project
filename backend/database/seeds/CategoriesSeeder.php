<?php

/**
 * Class CategoriesSeeder
 *
 * @author angelovicd
 */
class CategoriesSeeder extends DatabaseSeeder
{

    public function run()
    {
        $categories_array = array('zábava a šport',
            'konferencie',
            'erazmus');

        // adding categories in loop from array
        for ($i = 1; $i <= (sizeof($categories_array)); $i++) {
            DB::table('categories')->insert([
                'name' => $categories_array[$i - 1]]);
        }
    }
}
