<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('items', function(Blueprint $table)
		{
			$table->foreign('item_unit_id')->references('id')->on('item_units')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('stock_category_id')->references('id')->on('stock_categories')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('tax_type_id')->references('id')->on('tax_types')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('weight_unit_id')->references('id')->on('item_units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('items', function(Blueprint $table)
		{
			$table->dropForeign('items_item_unit_id_foreign');
			$table->dropForeign('items_stock_category_id_foreign');
			$table->dropForeign('items_tax_type_id_foreign');
			$table->dropForeign('items_weight_unit_id_foreign');
		});
	}

}
