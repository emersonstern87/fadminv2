<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
			$table->foreign('milestone_id')->references('id')->on('milestones')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('priority_id')->references('id')->on('priorities')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('task_status_id')->references('id')->on('task_statuses')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
			$table->dropForeign('tasks_milestone_id_foreign');
			$table->dropForeign('tasks_priority_id_foreign');
			$table->dropForeign('tasks_task_status_id_foreign');
			$table->dropForeign('tasks_user_id_foreign');
		});
	}

}
