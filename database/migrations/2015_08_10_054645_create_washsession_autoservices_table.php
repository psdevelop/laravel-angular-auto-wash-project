<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWashsessionAutoservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('washsession_autoservices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('washsession_id')->unsigned();
            $table->integer('autoservice_id')->unsigned(); // id of the record in autotype_services table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('washsession_autoservices');
    }
}
