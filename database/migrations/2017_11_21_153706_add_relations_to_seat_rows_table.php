<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsToSeatRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('seats', function ($table) {
            $table->integer('row_id')->nullable()->unsigned()->after('zone_id');
            $table->foreign('row_id')->references('id')->on('rows');
            $table->dropColumn('row');
            $table->double('space_to_left')->default(0.0)->after('space_to_right');
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
