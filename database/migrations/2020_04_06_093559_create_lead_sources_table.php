<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lead_sources', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 64)->unique();
			$table->string('status', 16)->default('active')->index()->comment('(\'active\',\'inactive\')');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lead_sources');
	}

}
