<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPurchaseOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_order_details', function(Blueprint $table)
		{
			$table->foreign('item_id')->references('id')->on('items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_order_details', function(Blueprint $table)
		{
			$table->dropForeign('purchase_order_details_item_id_foreign');
			$table->dropForeign('purchase_order_details_purchase_order_id_foreign');
		});
	}

}
