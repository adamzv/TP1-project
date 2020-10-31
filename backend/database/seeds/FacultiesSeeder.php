<?php


class FacultiesSeeder extends DatabaseSeeder
/*
 * adding faculties
 * author Dusan Angelovic as AngelovicD
 *
 */
{
    public function run()
    {
        DB::table('faculties')->insert([
            'name' => 'Fakulta prírodných vied',
        ]);
        DB::table('faculties')->insert([
            'name' => 'Fakulta sociálnych vied a zdravotníctva',
        ]);
        DB::table('faculties')->insert([
            'name' => 'Fakulta stredoeurópskych štúdií',
        ]);
        DB::table('faculties')->insert([
            'name' => 'Filozofická fakulta',
        ]);
        DB::table('faculties')->insert([
            'name' => 'Pedagogická fakulta',
        ]);
        DB::table('faculties')->insert([
            'name' => 'Univerzita Konštantína Filozofa', //events that are for the whole university.
                                                        //e.g. for all faculties.
        ]);
        DB::table('faculties')->insert([
            'name' => 'Univerzitná knižnica', // sometimes school library has events also
        ]);
    }
}



