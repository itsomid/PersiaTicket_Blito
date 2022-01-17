<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->timestamp('since_date')->useCurrent();
            $table->timestamp('until_date')->useCurrent();
            $table->integer('constant_discount')->default(0);
            $table->double('percent_discount')->default(0.0);
            $table->integer('usage_count')->default(-1);
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('show_id')->unsigned()->nullable();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->integer('created_by_user_id')->unsigned()->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->enum('status',['disabled','enabled'])->default('disabled');
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
        Schema::dropIfExists('promotions');
    }
}
