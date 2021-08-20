<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSaleOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sale_orders', function(Blueprint $table)
		{
			$table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('customer_branch_id')->references('id')->on('customer_branches')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('customer_id')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('location_id', 'sale_orders_lcoation_id_foreign')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('payment_term_id')->references('id')->on('payment_terms')->onUpdate('CASCADE')->onDelete('NO ACTION');
			$table->foreign('project_id')->references('id')->on('projects')->onUpdate('CASCADE')->onDelete('NO ACTION');
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
		Schema::table('sale_orders', function(Blueprint $table)
		{
			$table->dropForeign('sale_orders_currency_id_foreign');
			$table->dropForeign('sale_orders_customer_branch_id_foreign');
			$table->dropForeign('sale_orders_customer_id_foreign');
			$table->dropForeign('sale_orders_lcoation_id_foreign');
			$table->dropForeign('sale_orders_payment_term_id_foreign');
			$table->dropForeign('sale_orders_project_id_foreign');
			$table->dropForeign('sale_orders_user_id_foreign');
		});
	}

}
