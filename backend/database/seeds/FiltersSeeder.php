<?php

/**
 * Class FiltersSeeder
 *
 * @author angelovicd
 */
class FiltersSeeder extends DatabaseSeeder
{

    public function run()
    {

        // adding filters with loop also from array for easy changes.
        $filters_array = array('start_date',
            'end_date',
            'category',
            'place',
            'faculty',
            'department',
            'event_name');
        for ($i = 1; $i <= (sizeof($filters_array)); $i++) {
            DB::table('filters')->insert([
                'name' => $filters_array[$i - 1]]);
        }
    }
}
