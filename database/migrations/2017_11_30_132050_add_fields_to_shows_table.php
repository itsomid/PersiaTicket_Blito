<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shows', function ($table) {
            $table->string('details')->nullable()->after('description');
            $table->integer('source_id')->unsigned()->default(1)->after('details');
            $table->foreign('source_id')->references('id')->on('sources');
            $table->integer('source_related_id')->nullable()->unsigned()->after('source_id');
            $table->string('source_details')->nullable()->after('source_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
