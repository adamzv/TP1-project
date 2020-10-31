<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /* database seeder calls other classes
     * each class inserts its info as it is clear from its name.
     * author Dusan Angelovic as AngelovicD
     */
    public function run()
    {
        Model::unguard();
        $this->call(CategoriesSeeder::class);
        $this->call(FacultiesSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(FiltersSeeder::class);
        $this->call(RolesSeeder::class);
        Model::reguard();
    }
}
