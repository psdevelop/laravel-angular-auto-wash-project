<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinishTimeToWashsessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('washsessions', function (Blueprint $table) {
            $table->dateTime("finished_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('washsessions', function (Blueprint $table) {
            $table->dropColumn('finished_at');
        });
    }
}
