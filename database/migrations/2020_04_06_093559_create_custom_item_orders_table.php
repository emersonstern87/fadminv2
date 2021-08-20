<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomItemOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_item_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_no')->index();
			$table->integer('tax_type_id')->unsigned()->index('custom_item_orders_tax_type_id_foreign');
			$table->string('name', 150)->index();
			$table->decimal('quantity', 16, 8);
			$table->decimal('unit_price', 16, 8);
			$table->decimal('discount_percent', 11, 8);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_item_orders');
	}

}
