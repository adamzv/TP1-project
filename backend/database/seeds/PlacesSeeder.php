<?php

use Illuminate\Database\Seeder;

/**
 * Class PlacesSeeder
 *
 * @author klukak
 */
class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Place::class, 10)->create();
    }
}
