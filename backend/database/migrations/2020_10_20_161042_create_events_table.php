<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateEventsTable
 *
 * @author lacal
 */
class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('desc')->nullable();
            $table->dateTime('beginning');
            $table->dateTime('end')->nullable();
            $table->integer('attendance_limit');
            $table->foreign('id_user')->references('id')->on('states');
            $table->foreign('id_place')->references('id')->on('places');
            $table->foreign('id_faculty')->references('id')->on('faculties');
            $table->integer('id_department')->nullable()->unsigned();
            $table->foreign('id_repeat')->references('id')->on('repeats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
