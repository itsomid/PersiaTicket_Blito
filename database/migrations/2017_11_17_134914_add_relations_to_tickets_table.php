<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function ($table) {
            $table->integer('source_id')->nullable()->unsigned()->after('showtime_id');
            $table->foreign('source_id')->references('id')->on('sources');
            $table->integer('order_id')->unsigned()->nullable()->after('reserved_at');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
