<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStockAdjustmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stock_adjustments', function(Blueprint $table)
		{
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
		Schema::table('stock_adjustments', function(Blueprint $table)
		{
			$table->dropForeign('stock_adjustments_location_id_foreign');
			$table->dropForeign('stock_adjustments_user_id_foreign');
		});
	}

}
