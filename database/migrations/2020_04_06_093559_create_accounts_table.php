<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_type_id')->unsigned()->index();
			$table->string('name', 30)->index();
			$table->string('account_number', 30)->index();
			$table->integer('income_expense_category_id')->unsigned()->nullable()->index('accounts_income_expense_category_id_foreign_idx');
			$table->integer('currency_id')->unsigned()->index('accounts_currency_id_foreign_idx');
			$table->string('bank_name', 100)->index();
			$table->string('branch_name', 50)->nullable();
			$table->string('branch_city', 50)->nullable();
			$table->string('swift_code', 100)->nullable();
			$table->string('bank_address')->nullable();
			$table->boolean('is_default')->default(0)->index();
			$table->boolean('is_deleted')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts');
	}

}
