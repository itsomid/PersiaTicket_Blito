<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->integer('source_related_id')->nullable()->unsigned()->after('price');
            $table->json('source_details')->nullable()->after('source_related_id');
            $table->integer('source_id')->unsigned()->default(1)->after('source_related_id');
            $table->foreign('source_id')->references('id')->on('sources');
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
