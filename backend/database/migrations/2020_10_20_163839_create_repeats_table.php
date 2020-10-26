<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class CreateRepeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('repeatUnit', 255)->nullable();
            $table->integer('repeatNumber')->nullable();
            $table->dateTime('repeatUntil')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repeats');
    }
}
