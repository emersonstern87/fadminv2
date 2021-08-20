<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToShipmentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shipment_details', function(Blueprint $table)
		{
			$table->foreign('item_id')->references('id')->on('items')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('shipment_id')->references('id')->on('shipments')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('tax_type_id')->references('id')->on('tax_types')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shipment_details', function(Blueprint $table)
		{
			$table->dropForeign('shipment_details_item_id_foreign');
			$table->dropForeign('shipment_details_shipment_id_foreign');
			$table->dropForeign('shipment_details_tax_type_id_foreign');
		});
	}

}
