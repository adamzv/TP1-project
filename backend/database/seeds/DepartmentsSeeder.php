<?php

use Illuminate\Support\Facades\DB;

/**
 * Class DepartmentsSeeder
 *
 * Adding departments to its faculties.
 *
 * @author angelovicd
 */
class DepartmentsSeeder extends DatabaseSeeder
{

    public function run()
    {

        // adding each departments from its own array in loop so its easily changeable, if needed.
        $fpv_array = array('Katedra zoológie a antropológie', 'Katedra chémie', 'Gemologický ústav',
            'Katedra informatiky', 'Katedra matematiky', 'Ústav ekonomiky a manažmentu',
            'Katedra geografie a regionálneho rozvoja', 'Katedra fyziky',
            'Katedra ekológie a enviromentalistiky', 'Katedra botaniky a genetiky');
        for ($i = 1; $i <= (sizeof($fpv_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $fpv_array[$i - 1],
                'id_faculty' => 1,]);
        }

        $fsvaz_array = array('Katedra sociálnej práce a sociálnych vied', 'Ústav aplikovanej psychológie', 'Katedra psychologických vied',
            'Ústav romologických štúdií', 'Katedra ošetrovateľstva', 'Katedra klinických disciplín a urgentnej medicíny');
        for ($i = 1; $i <= (sizeof($fsvaz_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $fsvaz_array[$i - 1],
                'id_faculty' => 2,]);
        }

        $fsš_array = array('Katedra cestovného ruchu', 'Ústav maďarskej jazykovedy a literárnej vedy',
            'Ústav pre vzdelávanie pedagógov', 'Ústav stredoeurópskych jazykov a kultúr');
        for ($i = 1; $i <= (sizeof($fsš_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $fsš_array[$i - 1],
                'id_faculty' => 3,]);
        }

        $ff_array = array('Katedra anglistiky a amerikanistiky',
            'Katedra archeológie',
            'Katedra etnológie a folkloristiky',
            'Katedra filozofie',
            'Katedra germanistiky',
            'Katedra histórie',
            'Katedra kulturológie',
            'Katedra manažmentu kultúry a turizmu',
            'Katedra masmediálnej komunikácie a reklamy',
            'Katedra muzeológie',
            'Katedra náboženských štúdií',
            'Katedra politológie a euroázijských štúdií',
            'Katedra romanistiky',
            'Katedra rusistiky',
            'Katedra slovenského jazyka a literatúry',
            'Katedra sociológie',
            'Katedra translatológie',
            'Katedra všeobecnej a aplikovanej etiky',
            'Katedra žurnalistiky',
            'Mediálne centrum',
            'Tlmočnícky ústav',
            'Ústav literárnej a umeleckej komunikácie',
            'Ústav pre výskum kultúrneho dedičstva Konštantína a Metoda',
            'Centrum digitálnych humanitných vied',
            'Jazykové centrum');
        for ($i = 1; $i <= (sizeof($ff_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $ff_array[$i - 1],
                'id_faculty' => 4,]);
        }

        $pf_array = array('Katedra hudby',
            'Katedra lingvodidaktiky a interkultúrnych štúdií',
            'Katedra pedagogiky',
            'Katedra pedagogickej a školskej psychológie',
            'Katedra techniky a informačných technológií',
            'Katedra telesnej výchovy a športu',
            'Katedra výtvarnej tvorby a výchovy');
        for ($i = 1; $i <= (sizeof($pf_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $pf_array[$i - 1],
                'id_faculty' => 5,]);
        }
    }
}
