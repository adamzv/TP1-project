<?php

use Illuminate\Database\Seeder;

/**
 * Class EventSeeder
 *
 * @author klukak
 */
class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Event::class, 30)->create();
    }
}
