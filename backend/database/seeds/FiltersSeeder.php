<?php


class FiltersSeeder extends DatabaseSeeder
{
    public function run()
    {
        //vlozenie filtrov
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
