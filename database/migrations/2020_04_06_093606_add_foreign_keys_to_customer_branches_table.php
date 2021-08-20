<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomerBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_branches', function(Blueprint $table)
		{
			$table->foreign('billing_country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('shipping_country_id')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customer_branches', function(Blueprint $table)
		{
			$table->dropForeign('customer_branches_billing_country_id_foreign');
			$table->dropForeign('customer_branches_customer_id_foreign');
			$table->dropForeign('customer_branches_shipping_country_id_foreign');
		});
	}

}
