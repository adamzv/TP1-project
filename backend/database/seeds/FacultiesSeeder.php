<?php

/**
 * Class FacultiesSeeder
 *
 * Adding faculties
 *
 * @author angelovicd
 */
class FacultiesSeeder extends DatabaseSeeder
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

        // events that are for the whole university. e.g. for all faculties.
        DB::table('faculties')->insert([
            'name' => 'Univerzita Konštantína Filozofa',
        ]);

        // sometimes school library has events also
        DB::table('faculties')->insert([
            'name' => 'Univerzitná knižnica',
        ]);
    }
}



