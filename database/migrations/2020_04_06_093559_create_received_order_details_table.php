<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReceivedOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('received_order_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('purchase_order_id')->unsigned()->index('received_order_details_purchase_order_id_foreign_idx');
			$table->integer('purchase_order_detail_id')->unsigned()->index('received_order_details_purchase_order_details_id_index');
			$table->integer('received_order_id')->unsigned()->index('received_order_details_received_order_id_foreign_idx');
			$table->integer('item_id')->unsigned()->nullable()->index('receive_order_details_item_id_foreign');
			$table->string('item_name')->index();
			$table->decimal('unit_price', 16, 8);
			$table->decimal('quantity', 16, 8);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('received_order_details');
	}

}
