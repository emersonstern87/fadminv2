<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToExpensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('expenses', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('income_expense_category_id')->references('id')->on('income_expense_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('transaction_reference_id')->references('id')->on('transaction_references')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('expenses', function(Blueprint $table)
		{
			$table->dropForeign('expenses_currency_id_foreign');
			$table->dropForeign('expenses_income_expense_category_id_foreign');
			$table->dropForeign('expenses_payment_method_id_foreign');
			$table->dropForeign('expenses_transaction_id_foreign');
			$table->dropForeign('expenses_transaction_reference_id_foreign');
			$table->dropForeign('expenses_user_id_foreign');
		});
	}

}
