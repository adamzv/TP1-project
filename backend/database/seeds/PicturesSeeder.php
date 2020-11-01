<?php

use Illuminate\Database\Seeder;

/**
 * Class PictureSeeder
 *
 * @author klukak
 */
class PicturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Picture::class, 50)->create();
    }
}
