<?php

use Illuminate\Database\Seeder;
use \App\Models\State;

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

        $city_array = array('Bánovce nad Bebravou',
            'Banská Bystrica',
            'Banská Štiavnica',
            'Bardejov',
            'Bratislava I',
            'Bratislava II',
            'Bratislava III',
            'Bratislava IV',
            'Bratislava V',
            'Brezno',
            'Bytča',
            'Čadca',
            'Detva',
            'Dolný Kubín',
            'Dunajská Streda',
            'Galanta',
            'Gelnica',
            'Hlohovec',
            'Humenné',
            'Ilava',
            'Kežmarok',
            'Komárno',
            'Košice I',
            'Košice II',
            'Košice III',
            'Košice IV',
            'Košice-okolie',
            'Krupina',
            'Kysucké Nové Mesto',
            'Levice',
            'Levoča',
            'Liptovský Mikuláš',
            'Lučenec',
            'Malacky',
            'Martin',
            'Medzilaborce',
            'Michalovce',
            'Myjava',
            'Námestovo',
            'Nitra',
            'Nové Mesto nad Váhom',
            'Nové Zámky',
            'Partizánske',
            'Pezinok',
            'Piešťany',
            'Poltár',
            'Poprad',
            'Považská Bystrica',
            'Prešov',
            'Prievidza',
            'Púchov',
            'Revúca',
            'Rimavská Sobota',
            'Rožňava',
            'Ružomberok',
            'Sabinov',
            'Senec',
            'Senica',
            'Skalica',
            'Snina',
            'Sobrance',
            'Spišská Nová Ves',
            'Stará Ľubovňa',
            'Stropkov',
            'Svidník',
            'Šaľa',
            'Topoľčany',
            'Trebišov',
            'Trenčín',
            'Trnava',
            'Turčianske Teplice',
            'Tvrdošín',
            'Veľký Krtíš',
            'Vranov nad Topľou',
            'Zlaté Moravce',
            'Zvolen',
            'Žarnovica',
            'Žiar nad Hronom',
            'Žilina');

        // adding categories in loop from array
        for ($i = 1; $i <= (sizeof($city_array)); $i++) {
            DB::table('cities')->insert([
                'name' => $city_array[$i - 1],
                'id_state' => 1]);
        }
    }
}
