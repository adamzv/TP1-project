<?php

use Illuminate\Database\Seeder;

/**
 * Class CitiesSeeder
 *
 * @author klukak
 */
class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\City::class, 20)->create();
    }
}
