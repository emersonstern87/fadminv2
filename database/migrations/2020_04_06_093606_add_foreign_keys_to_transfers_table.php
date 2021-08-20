<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transfers', function(Blueprint $table)
		{
			$table->foreign('from_account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('from_currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('to_account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('to_currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('transaction_reference_id', 'transfers_transaction_reference_id')->references('id')->on('transaction_references')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
		Schema::table('transfers', function(Blueprint $table)
		{
			$table->dropForeign('transfers_from_account_id_foreign');
			$table->dropForeign('transfers_from_currency_id_foreign');
			$table->dropForeign('transfers_to_account_id_foreign');
			$table->dropForeign('transfers_to_currency_id_foreign');
			$table->dropForeign('transfers_transaction_reference_id');
			$table->dropForeign('transfers_user_id_foreign');
		});
	}

}
