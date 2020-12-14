<?php

use App\Models\City;
use Illuminate\Database\Seeder;

/**
 * Class PlacesSeeder
 *
 * @author klukak, lacal
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
        // factory(\App\Models\Place::class, 10)->create();
        $places_array = array(
            'Trieda Andreja Hlinku 1',
            'Nábrežie mládeže 91',
            'Štefánikova trieda 67',
            'Kraskova 1',
            'Dražovská 4',
            'Boženy Slančíkovej 1',
            'Nábrežie mládeže 1',
            'Hodžova 1');

        // get city id of Nitra
        $nitra = City::orderBy('name')
            ->where('cities.name', '=', 'Nitra')
            ->get()->pluck('id');

        // adding streets in loop from array
        for ($i = 1; $i <= (sizeof($places_array)); $i++) {
            DB::table('places')->insert([
                'name' => $places_array[$i - 1],
                'id_city' => $nitra[0]]);
        }
    }
}
