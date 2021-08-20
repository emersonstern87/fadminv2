<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('accounts', function(Blueprint $table)
		{
			$table->foreign('account_type_id')->references('id')->on('account_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('income_expense_category_id')->references('id')->on('income_expense_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropForeign('accounts_account_type_id_foreign');
			$table->dropForeign('accounts_currency_id_foreign');
			$table->dropForeign('accounts_income_expense_category_id_foreign');
		});
	}

}
