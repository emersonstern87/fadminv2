<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPurchaseOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_orders', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('location_id')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('payment_term_id')->references('id')->on('payment_terms')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('purchase_receive_type_id')->references('id')->on('purchase_receive_types')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_orders', function(Blueprint $table)
		{
			$table->dropForeign('purchase_orders_currency_id_foreign');
			$table->dropForeign('purchase_orders_location_id_foreign');
			$table->dropForeign('purchase_orders_payment_term_id_foreign');
			$table->dropForeign('purchase_orders_purchase_receive_type_id_foreign');
			$table->dropForeign('purchase_orders_supplier_id_foreign');
			$table->dropForeign('purchase_orders_user_id_foreign');
		});
	}

}
