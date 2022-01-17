<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('row')->nullable();
            $table->integer('zone_id')->unsigned();
            $table->foreign('zone_id')->references('id')->on('zones');
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
        Schema::dropIfExists('seat_rows');
    }
}
