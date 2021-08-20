<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->foreign('account_id', 'transactions_ account_no_foreign')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('transaction_reference_id')->references('id')->on('transaction_references')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->dropForeign('transactions_ account_no_foreign');
			$table->dropForeign('transactions_currency_id_foreign');
			$table->dropForeign('transactions_payment_method_id_foreign');
			$table->dropForeign('transactions_transaction_reference_id_foreign');
		});
	}

}
