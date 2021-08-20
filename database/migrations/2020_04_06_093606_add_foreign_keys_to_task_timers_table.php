<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaskTimersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task_timers', function(Blueprint $table)
		{
			$table->foreign('task_id')->references('id')->on('tasks')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('task_timers', function(Blueprint $table)
		{
			$table->dropForeign('task_timers_task_id_foreign');
			$table->dropForeign('task_timers_user_id_foreign');
		});
	}

}
