<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDepositsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('deposits', function(Blueprint $table)
		{
			$table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('income_expense_category_id')->references('id')->on('income_expense_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
		Schema::table('deposits', function(Blueprint $table)
		{
			$table->dropForeign('deposits_account_id_foreign');
			$table->dropForeign('deposits_income_expense_category_id_foreign');
			$table->dropForeign('deposits_payment_method_id_foreign');
			$table->dropForeign('deposits_transaction_reference_id_foreign');
			$table->dropForeign('deposits_user_id_foreign');
		});
	}

}
