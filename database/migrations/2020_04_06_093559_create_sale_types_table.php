<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSaleTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sale_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sale_type', 25)->index();
			$table->boolean('is_tax_included');
			$table->boolean('is_default')->default(0)->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sale_types');
	}

}
