<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * Calls other classes. Each class inserts its info as it is clear from its name.
 *
 * @author angelovicd
 */
class DatabaseSeeder extends Seeder
{

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
