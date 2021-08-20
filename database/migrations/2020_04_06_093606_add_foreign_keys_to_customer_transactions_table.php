<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomerTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_transactions', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('sale_order_id')->references('id')->on('sale_orders')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('transaction_reference_id')->references('id')->on('transaction_references')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::table('customer_transactions', function(Blueprint $table)
		{
			$table->dropForeign('customer_transactions_currency_id_foreign');
			$table->dropForeign('customer_transactions_customer_id_foreign');
			$table->dropForeign('customer_transactions_payment_method_id_foreign');
			$table->dropForeign('customer_transactions_sale_order_id_foreign');
			$table->dropForeign('customer_transactions_transaction_reference_id_foreign');
			$table->dropForeign('customer_transactions_user_id_foreign');
		});
	}

}
