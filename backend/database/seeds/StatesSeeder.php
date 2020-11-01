<?php

use Illuminate\Database\Seeder;

/**
 * Class StateSeeder
 *
 * @author klukak
 */
class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\State::class)->create();
    }
}
