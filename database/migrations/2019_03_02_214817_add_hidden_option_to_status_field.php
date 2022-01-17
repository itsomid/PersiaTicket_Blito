<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHiddenOptionToStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE shows MODIFY COLUMN status ENUM('disabled','enabled','finished', 'canceled','pending','hidden') DEFAULT 'disabled' NOT NULL");
//        DB::statement("ALTER TABLE shows MODIFY status ENUM('disabled','enabled','finished', 'canceled','pending','hidden') DEFAULT 'disabled'");
//        Schema::table('shows',function (Blueprint $table){
//        DB::statement("ALTER TABLE shows CHANGE COLUMN status ENUM('disabled','enabled','finished', 'canceled','pending','hidden')");
////            $table->enum('status',['disabled','enabled','finished', 'canceled','pending','hidden' ])->default('disabled');
//        });
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
