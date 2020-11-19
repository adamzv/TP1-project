<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class CreateEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->bigIncrements('id');

            // foreign ids
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('email_id')->nullable();

            // foreign relationships
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('email_id')->references('id')->on('emails');
            $table->unique(['user_id', 'event_id', 'email_id']);
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
        Schema::dropIfExists('event_user');
    }
}
