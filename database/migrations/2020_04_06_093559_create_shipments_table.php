<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sale_order_id')->unsigned()->index('shipments_sale_order_id_foreign_idx');
			$table->text('comment', 65535);
			$table->string('status', 10)->default('0')->index();
			$table->date('packed_date');
			$table->date('delivery_date');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shipments');
	}

}
