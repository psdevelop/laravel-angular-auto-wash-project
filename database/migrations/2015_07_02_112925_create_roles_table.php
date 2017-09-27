<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title');
			$table->string('name');
            $table->timestamps();
        });
		
		DB::table('roles')->insert(
		  array(
		    'name' => 'Администратор',
		    'title' => 'Administrator'
		  )
		);
		DB::table('roles')->insert(
		  array(
		    'name' => 'Директор',
		    'title' => 'Director'
		  )
		);
		DB::table('roles')->insert(
		  array(
		    'name' => 'Менеджер',
		    'title' => 'Manager'
		  )
		);
		DB::table('roles')->insert(
		  array(
		    'name' => 'Оператор',
		    'title' => 'Operator'
		  )
		);
		
		DB::table('users')->insert(
		  array(
		    'name' => 'Admin',
		    'email' => 'vladimirsv85@gmail.com',
			'role_id' => 1,
			'password' => '$2y$10$KAvSF1RXnY9EpuqpWThgGO9dkd2zFW3E1hYBQzXxfpfe4C.7rl5y.'
		  )
		);
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
