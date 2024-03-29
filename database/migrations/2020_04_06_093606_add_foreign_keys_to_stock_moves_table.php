<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStockMovesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stock_moves', function(Blueprint $table)
		{
			$table->foreign('item_id')->references('id')->on('items')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('location_id')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::table('stock_moves', function(Blueprint $table)
		{
			$table->dropForeign('stock_moves_item_id_foreign');
			$table->dropForeign('stock_moves_location_id_foreign');
			$table->dropForeign('stock_moves_user_id_foreign');
		});
	}

}
