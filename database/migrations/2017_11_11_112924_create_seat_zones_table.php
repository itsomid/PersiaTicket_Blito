<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('x')->default(0.0);
            $table->double('y')->default(0.0);
            $table->string('zonemap_image_url')->nullable();
            $table->integer('scene_id')->unsigned();
            $table->foreign('scene_id')->references('id')->on('scenes');
            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans');

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
        Schema::dropIfExists('seat_zones');
    }
}
