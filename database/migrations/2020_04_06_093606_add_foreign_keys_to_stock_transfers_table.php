<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStockTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stock_transfers', function(Blueprint $table)
		{
			$table->foreign('destination_location_id')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('source_location_id')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::table('stock_transfers', function(Blueprint $table)
		{
			$table->dropForeign('stock_transfers_destination_location_id_foreign');
			$table->dropForeign('stock_transfers_source_location_id_foreign');
			$table->dropForeign('stock_transfers_user_id_foreign');
		});
	}

}
