<?php


class FiltersSeeder extends DatabaseSeeder
{
    public function run()
    {
        //vlozenie filtrov
        DB::table('filters')->insert([
            'name'=>'start_date',
            'name'=>'end_date',
            'name'=>'category',
            'name'=>'place',
            'name'=>'faculty',
            'name'=>'department',
            'name'=>'event_name',
        ]);
            }
}
