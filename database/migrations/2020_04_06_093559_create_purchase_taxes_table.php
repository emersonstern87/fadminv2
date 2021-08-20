<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_taxes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('purchase_order_detail_id')->unsigned()->index('purchase_taxes_purchase_order_detail_id_foreign_idx');
			$table->integer('tax_type_id')->unsigned()->index('purchase_taxes_tax_type_id_foreign_idx');
			$table->decimal('tax_amount', 16, 8)->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('purchase_taxes');
	}

}
