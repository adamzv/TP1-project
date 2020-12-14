<?php

use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        //factory(\App\Models\Event::class, 30)->create();
        DB::table('events')->insert([
            'name' => 'Oboznámenie sa s prostredím',
            'desc' => 'Zoznámte sa s naším prostredím',
            'beginning' => '2020-12-17 09:22:24',
            'end' => '2020-12-18 09:22:24',
            'id_user' => User::all()->random()->id,
            'id_place' => Place::all()->random()->id,
            'id_faculty' => 1,
            'id_department' => 2]);
    }
}
