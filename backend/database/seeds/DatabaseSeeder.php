<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    /* REQUIREMENTS AND RESEARCH
     *
     * Cieľom je vytvorenie seederov pre generovanie dát potrebných pre správne fungovanie systému.

    Tabuľky:
    fakulta ako univerzita ako celok
    faculties and departments

     *   prírodných vied
           * Katedra zoologie a antropológie
           * Katedra chémie
           * Katedra gemologický ústav
           * Katedra matematiky
           * Katedra geografie a regionálneho rozvoja
           * Katedra ekonomiky a manažmentu
           * Katedra informatiky
           * Katedra fyziky
           * Katedra ekológie a enviromentalistiky
           * Katedra botaniky a genetiky

     *   sociálnych vied a zdravotníctva
         * Katedra sociálnej práce asociálnych vied
         * Ústav aplikovanej psychológie
         * Ústav romologických štúdií
         * Katedra ošetrovateľstva
         * Katedra klinických disciplín aurgentnej medicíny

     *   stredoeurópskych štúdií
         * Katedra cestovného ruchu
         * Ústav maďarskej jazykovedy a literárnej vedy
         * Ústav pre vzdelávanie pedagógov
         * Ústaav stredoeurópskych jazykov a kultúr

     *   filozofická
         * Katedra anglistiky a amerikanistiky
         * Katedra archeológie
         * Katedra etnológie a folkloristiky
         * Katedra filozofie
         * Katedra germanistiky
         * Katedra histórie
         * Katedra kulturológie
         * Katedra manažmentu kultúry a turizmu
         * Katedra masmediálnej komunikácie a reklamy
         * Katedra muzeológie
         * Katedra náboženských štúdií
         * Katedra politológie a euroázijských štúdií
         * Katedra romanistiky
         * Katedra rusistiky
         * Katedra slovenského jazyka a literatúry
         * Katedra sociológie
         * Katedra translatológie
         * Katedra všeobecnej a aplikovanej etiky
         * Katedra žurnalistiky
         * Mediálne centrum
         * Tlmočnícky ústav
         * Ústav literárnej a umeleckej komunikácie
            (estetika, estetická výchova)
         * Ústav pre výskum kultúrneho dedičstva Konštantína a Metoda
         * Centrum digitálnych humanitných vied
         * Jazykové centrum

     *   pedagogická
         * Katedra hudby
         * Katedra lingvodidaktiky a interkultúrnych štúdií
         * Katedra pedagogiky
         * Katedra pedagogickej a školskej psychológie
         * Katedra techniky a informačných technológií
         * Katedra telesnej výchovy a športu
         * Katedra výtvarnej tvorby a výchovy

    filters - treba sa dohodnúť s frontendom ako budeme volať jednotlivé položky vo filtri
    date
    category
    place
    departments


    roles - role ktoré máme v požiadavkách
        admin , moderator, pouzivatel, host

    categories - stačí pár vymyslieť, viac by sa mohli generovať vo factories náhodne.
        ako letné hry, konferencie, pracovné dni, zábava a šport*/

    public function run()
    {
        Model::unguard();
        $this->call(CategoriesSeeder::class);
        $this->call(FacultiesSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(FiltersSeeder::class);
        $this->call(RolesSeeder::class);
        Model::reguard();
    }
}
