<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_statuses', function(Blueprint $table)
		{
			$table->integer('id')->unsigned()->primary();
			$table->string('name', 50);
			$table->boolean('status_order');
			$table->string('color', 20);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_statuses');
	}

}
