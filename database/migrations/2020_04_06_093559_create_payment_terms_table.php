<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentTermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_terms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50)->index();
			$table->integer('days_before_due');
			$table->boolean('is_default')->default(0)->index()->comment('1 for default;0 for otherwise;');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payment_terms');
	}

}
