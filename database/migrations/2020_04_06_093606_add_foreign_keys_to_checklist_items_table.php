<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChecklistItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('checklist_items', function(Blueprint $table)
		{
			$table->foreign('task_id')->references('id')->on('tasks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('checklist_items', function(Blueprint $table)
		{
			$table->dropForeign('checklist_items_task_id_foreign');
		});
	}

}
