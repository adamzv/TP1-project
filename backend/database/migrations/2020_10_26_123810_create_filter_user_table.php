<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class CreateFilterUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filter_value', 255);

            // foreign ids
            $table->unsignedBigInteger('id_filter');
            $table->unsignedBigInteger('id_user');

            // foreign relationships
            $table->foreign('id_filter')->references('id')->on('filters')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('filter_user');
    }
}
