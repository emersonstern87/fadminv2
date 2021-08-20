<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_configurations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('protocol');
			$table->string('encryption');
			$table->string('smtp_host');
			$table->string('smtp_port');
			$table->string('smtp_email');
			$table->string('smtp_username');
			$table->string('smtp_password');
			$table->string('from_address');
			$table->string('from_name');
			$table->boolean('status')->default(0)->comment('1= varified, 0= unverified');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_configurations');
	}

}
