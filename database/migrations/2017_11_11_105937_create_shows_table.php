<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('artist_name')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->enum('status',['disabled','enabled','finished', 'canceled','pending'])->default('disabled');
            $table->string('thumb_url');
            $table->string('main_image_url');
            $table->string('background_color')->nullable();
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->enum('ticket_status',['none','renewed','soon','sold_out'])->default('none');

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
        Schema::dropIfExists('shows');
    }
}
