<?php


use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends DatabaseSeeder
{

    public function run()
    {

        //vloženie katedier a súčastí
        $fpv_array = array('Katedra zoológie a antropológie', 'Katedra chémie', 'Gemologický ústav',
            'Katedra informatiky', 'Katedra zoológie a antropológie', 'Katedra matematiky',
            'Katedra geografie a regionálneho rozvoja', 'Katedra fyziky',
            'Katedra ekológie a enviromentalistiky', 'Katedra botaniky a genetiky');

        for ($i = 1; $i <= (sizeof($fpv_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $fpv_array[$i - 1],
                'id_faculty' => 1,]);
        }

        $fsvaz_array = array('Katedra sociálnej práce asociálnych vied', 'Ústav aplikovanej psychológie',
            'Ústav romologických štúdií', 'Katedra ošetrovateľstva', 'Katedra klinických disciplín aurgentnej medicíny');

        for ($i = 1; $i <= (sizeof($fsvaz_array)); $i++) {
            DB::table('departments')->insert([
                'name' => $fsvaz_array[$i - 1],
                'id_faculty' => 2,]);
        }
        $fsš_array = array('Katedra cestovného ruchu', 'Ústav maďarskej jazykovedy a literárnej vedy',
            'Ústav pre vzdelávanie pedagógov', 'Ústaav stredoeurópskych jazykov a kultúr');

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
            'Katedra sociológie',
            'Katedra translatológie',
            'Katedra všeobecnej a aplikovanej etiky',
            'Katedra žurnalistiky',
            'Mediálne centrum',
            'Tlmočnícky ústav',
            'Katedra žurnalistiky',
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
/*

                'Katedra hudby',
                'Katedra lingvodidaktiky a interkultúrnych štúdií',
                'Katedra pedagogiky',
                'Katedra pedagogickej a školskej psychológie',
                'Katedra techniky a informačných technológií',
                'Katedra telesnej výchovy a športu',
                'Katedra výtvarnej tvorby a výchovy'
                'id_faculty'=>'5'//pf
            ]);
        }
    }
}
*/
