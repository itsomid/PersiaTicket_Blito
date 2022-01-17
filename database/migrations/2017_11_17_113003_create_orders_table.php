<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('price')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('showtime_id')->unsigned()->nullable();
            $table->foreign('showtime_id')->references('id')->on('showtimes');
            $table->enum('status',['approved', 'canceled','pending'])->default('pending');
            $table->enum('agent',['website','ios','android'])->default('website');
        });
        DB::update("ALTER TABLE orders AUTO_INCREMENT = 13021;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
