<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->integer('price')->default(0);
            $table->string('code')->default('');
            $table->integer('seat_id')->unsigned()->nullable();
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->integer('showtime_id')->unsigned();
            $table->foreign('showtime_id')->references('id')->on('showtimes');
            $table->integer('reserved_by_user_id')->unsigned()->nullable();
            $table->foreign('reserved_by_user_id')->references('id')->on('users');
            $table->timestamp('reserved_at')->nullable();
            $table->enum('status',['disabled','available','reserved', 'sold','external'])->default('disabled');
            $table->timestamps();
        });
        $statement = "ALTER TABLE tickets AUTO_INCREMENT = 11241;";
        DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
