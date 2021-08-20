<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemCustomVariantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_custom_variants', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('item_id')->unsigned()->index('item_custom_variants_item_id_idx')->comment('item_id refers the items table id column');
			$table->string('variant_title', 240)->index();
			$table->string('variant_value', 240)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_custom_variants');
	}

}
