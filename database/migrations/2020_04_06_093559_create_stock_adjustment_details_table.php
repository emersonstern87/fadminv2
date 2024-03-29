<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStockAdjustmentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_adjustment_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('stock_adjustment_id')->unsigned()->index('stock_adjustment_details_stock_adjustment_id_foreign_idx')->comment('stock_adjustment_id refers to stock_adjustments table id');
			$table->integer('item_id')->unsigned()->index('stock_adjustment_details_item_id_foreign_idx')->comment('item_id referes to items table id');
			$table->text('description', 65535);
			$table->decimal('quantity', 16, 8);
			$table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stock_adjustment_details');
	}

}
