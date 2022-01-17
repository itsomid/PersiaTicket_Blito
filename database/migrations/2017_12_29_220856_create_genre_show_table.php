<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_show', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('show_id')->unsigned()->nullable();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->integer('genre_id')->unsigned()->nullable();
            $table->foreign('genre_id')->references('id')->on('genres');
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
        Schema::dropIfExists('genre_show');
    }
}
