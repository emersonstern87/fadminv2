<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaskAssignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task_assigns', function(Blueprint $table)
		{
			$table->foreign('assigned_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('task_id')->references('id')->on('tasks')->onUpdate('CASCADE')->onDelete('CASCADE');
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
		Schema::table('task_assigns', function(Blueprint $table)
		{
			$table->dropForeign('task_assigns_assigned_by_foreign');
			$table->dropForeign('task_assigns_task_id_foreign');
			$table->dropForeign('task_assigns_user_id_foreign');
		});
	}

}
