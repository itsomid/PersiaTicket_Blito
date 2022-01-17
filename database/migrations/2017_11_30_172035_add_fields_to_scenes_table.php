<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scenes', function ($table) {
            $table->integer('source_related_id')->nullable()->unsigned()->after('main_image_url');
            $table->integer('source_id')->unsigned()->default(1)->after('source_related_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');

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
