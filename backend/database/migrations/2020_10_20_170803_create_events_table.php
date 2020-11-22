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
            $table->string('room', 255)->nullable();
            $table->dateTime('beginning');
            $table->dateTime('end')->nullable();
            $table->integer('attendance_limit')->default(-1);
            $table->string('lecturer',255)->nullable();

            // foreign ids
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_place');
            $table->unsignedBigInteger('id_faculty');
            $table->unsignedBigInteger('id_department')->nullable()->unsigned();

            // foreign relationships
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_place')->references('id')->on('places');
            $table->foreign('id_faculty')->references('id')->on('faculties');
            $table->foreign('id_department')->references('id')->on('departments');

            // deleted repeats table

            $table->timestamps();
            $table->softDeletes();
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
