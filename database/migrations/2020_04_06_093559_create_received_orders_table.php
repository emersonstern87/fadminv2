<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReceivedOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('received_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('purchase_order_id')->unsigned()->index('receive_orders_purchase_order_id_foreign');
			$table->integer('user_id')->unsigned()->nullable()->index('receive_orders_user_id_foreign');
			$table->integer('supplier_id')->unsigned()->index('receive_orders_supplier_id_foreign');
			$table->string('reference', 50);
			$table->integer('location_id')->unsigned()->index('received_orders_location_id_foreign_idx');
			$table->date('receive_date')->index();
			$table->string('order_receive_no', 60)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('received_orders');
	}

}
