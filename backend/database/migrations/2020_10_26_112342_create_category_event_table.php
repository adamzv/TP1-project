<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCategoryEventTable
 *
 * @author lacal
 */
class CreateCategoryEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_category');

            // foreign relationships
            $table->foreign('id_event')->references('id')->on('events');
            $table->foreign('id_category')->references('id')->on('categories');
            $table->unique(['id_event', 'id_category']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_event');
    }
}
