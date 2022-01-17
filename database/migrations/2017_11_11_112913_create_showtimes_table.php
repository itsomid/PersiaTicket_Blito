<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datetime');
            $table->enum('status',['enabled','disabled'])->default('enabled');
            $table->integer('show_id')->unsigned();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->integer('scene_id')->unsigned();
            $table->foreign('scene_id')->references('id')->on('scenes');
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
        Schema::dropIfExists('showtimes');
    }
}
