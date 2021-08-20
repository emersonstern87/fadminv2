<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchasePricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('item_id')->unsigned()->index('purchase_prices_item_id_foreign');
			$table->integer('currency_id')->unsigned()->index('purchase_prices_currency_id_foreign_idx');
			$table->decimal('price', 16, 8)->nullable()->default(0)->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('purchase_prices');
	}

}
