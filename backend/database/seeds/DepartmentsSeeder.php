<?php


class DepartmentsSeeder extends DatabaseSeeder
{
    public function run(){
        {
            //vloženie katedier a súčastí
            DB::table('departments')->insert([
                'name'=>'Katedra zoologie a antropológie',
                'name'=>'Katedra chémie',
                'name'=>'Gemologický ústav',
                'name'=>'Katedra matematiky',
                'name'=>'Katedra geografie a regionálneho rozvoja',
                'name'=>'Katedra ekonomiky a manažmentu',
                'name'=>'Katedra informatiky',
                'name'=>'Katedra fyziky',
                'name'=>'Katedra ekológie a enviromentalistiky',
                'name'=>'Katedra botaniky a genetiky',
                'id_faculty'=>'1' //fpv
            ]);

            DB::table('departments')->insert([
                'name'=>'Katedra sociálnej práce asociálnych vied',
                'name'=>'Ústav aplikovanej psychológie',
                'name'=>'Ústav romologických štúdií',
                'name'=>'Katedra ošetrovateľstva',
                'name'=>'Katedra klinických disciplín aurgentnej medicíny',
                'id_faculty'=>'2' //svaz


            ]);
            DB::table('departments')->insert([
                'name'=>'Katedra cestovného ruchu',
                'name'=>'Ústav maďarskej jazykovedy a literárnej vedy',
                'name'=>'Ústav pre vzdelávanie pedagógov',
                'name'=>'Ústaav stredoeurópskych jazykov a kultúr',
                'id_faculty'=>'3' //fsš
            ]);
            DB::table('departments')->insert([
                'name'=>'Katedra anglistiky a amerikanistiky',
                'name'=>'Katedra archeológie',
                'name'=>'Katedra etnológie a folkloristiky',
                'name'=>'Katedra filozofie',
                'name'=>'Katedra germanistiky',
                'name'=>'Katedra histórie',
                'name'=>'Katedra kulturológie',
                'name'=>'Katedra manažmentu kultúry a turizmu',
                'name'=>'Katedra masmediálnej komunikácie a reklamy',
                'name'=>'Katedra muzeológie',
                'name'=>'Katedra náboženských štúdií',
                'name'=>'Katedra politológie a euroázijských štúdií',
                'name'=>'Katedra romanistiky',
                'name'=>'Katedra rusistiky',
                'name'=>'Katedra sociológie',
                'name'=>'Katedra translatológie',
                'name'=>'Katedra všeobecnej a aplikovanej etiky',
                'name'=>'Katedra žurnalistiky',
                'name'=>'Mediálne centrum',
                'name'=>'Tlmočnícky ústav',
                'name'=>'Katedra žurnalistiky',
                'name'=>'Ústav literárnej a umeleckej komunikácie',
                'name'=>'Ústav pre výskum kultúrneho dedičstva Konštantína a Metoda',
                'name'=>'Centrum digitálnych humanitných vied',
                'name'=>'Jazykové centrum',
                'id_faculty'=>'4' //ff
            ]);
            DB::table('departments')->insert([
                'name'=>'Katedra hudby',
                'name'=>'Katedra lingvodidaktiky a interkultúrnych štúdií',
                'name'=>'Katedra pedagogiky',
                'name'=>'Katedra pedagogickej a školskej psychológie',
                'name'=>'Katedra techniky a informačných technológií',
                'name'=>'Katedra telesnej výchovy a športu',
                'name'=>'Katedra výtvarnej tvorby a výchovy',
                'id_faculty'=>'5'//pf
            ]);
        }
    }
}
