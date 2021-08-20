<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipmentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shipment_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('shipment_id')->unsigned()->index('shipment_details_shipment_id_foreign');
			$table->integer('item_id')->unsigned()->index('shipment_details_item_id_foreign');
			$table->integer('tax_type_id')->unsigned()->index('shipment_details_tax_type_id_foreign');
			$table->decimal('unit_price', 16, 8)->index('shipments_unit_price_index');
			$table->decimal('quantity', 16, 8)->index('shipments_quantity_index');
			$table->decimal('discount_percent', 11, 8);
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
		Schema::drop('shipment_details');
	}

}
