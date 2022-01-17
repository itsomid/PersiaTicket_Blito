<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('via',['ipg'])->default('ipg');
            $table->string('authority')->nullable();
            $table->string('payment_details')->default('{}');
            $table->integer('amount')->default(0);
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->enum('status',['initializing','failed','pending','successful', 'canceled'])->default('initializing');
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
        Schema::dropIfExists('payments');
    }
}
