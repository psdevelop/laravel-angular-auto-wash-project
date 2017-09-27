<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutotypeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autotype_services', function (Blueprint $table) {
            $table->integer('auto_id')->unsigned();
      			$table->integer('service_id')->unsigned();
      			$table->decimal('cost', 18, 6);
      			$table->primary(['auto_id','service_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autotype_services');
    }
}
