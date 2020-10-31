<?php


class FiltersSeeder extends DatabaseSeeder
{
    /*
     * adding filters with loop also from array for easy changes
     * author Dusan Angelovic as AngelovicD
     */
    public function run()
    {
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
