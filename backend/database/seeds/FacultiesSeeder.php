<?php


class FacultiesSeeder extends DatabaseSeeder

{  // $this->call(UsersTableSeeder::class);
    //vloženie falúlt
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
            'name' => 'Univerzita Konštantína Filozofa', //eventy,ktoré sa týkajú celej univerzity
        ]);
        DB::table('faculties')->insert([
            'name' => 'Univerzitná knižnica', // niekedy ma aj kniznica eventy
        ]);
    }
}



