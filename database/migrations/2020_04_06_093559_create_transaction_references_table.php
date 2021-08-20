<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionReferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_references', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('object_id')->unsigned()->nullable();
			$table->string('reference_type', 50)->index();
			$table->string('code', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaction_references');
	}

}
