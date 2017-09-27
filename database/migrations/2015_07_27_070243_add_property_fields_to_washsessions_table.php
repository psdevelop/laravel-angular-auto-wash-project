<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyFieldsToWashsessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('washsessions', function (Blueprint $table) {
            $table->integer('wash_id')->unsigned();
			$table->integer('box_id')->unsigned();
			$table->integer('operator_id')->unsigned();
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
            $table->dropColumn('wash_id');
			$table->dropColumn('box_id');
			$table->dropColumn('operator_id');
			
        });
    }
}
