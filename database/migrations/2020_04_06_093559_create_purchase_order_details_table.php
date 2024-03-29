<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_order_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('purchase_order_id')->unsigned()->index('purchase_order_details_purchase_order_id_foreign_idx');
			$table->integer('item_id')->unsigned()->nullable()->index('purchase_order_details_item_id_foreign_idx');
			$table->string('description')->nullable();
			$table->string('item_name')->index();
			$table->decimal('discount', 11, 8)->unsigned()->default(0);
			$table->string('discount_type', 1)->comment('% or $');
			$table->string('hsn', 250)->nullable();
			$table->boolean('sorting_no');
			$table->decimal('discount_amount', 16, 8)->unsigned()->default(0);
			$table->decimal('unit_price', 16, 8)->default(0);
			$table->decimal('quantity_ordered', 16, 8)->unsigned()->default(0);
			$table->decimal('quantity_received', 16, 8)->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('purchase_order_details');
	}

}
