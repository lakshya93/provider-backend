<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('service_type_id')->unsigned();
			$table->foreign('service_type_id')->references('id')->on('service_types')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('rating');

			$table->string('business_name');
			$table->longText('business_address');
			$table->string('business_mobile');
			$table->string('business_landline');
			$table->string('business_zipcode');
			$table->string('business_city');

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
		Schema::drop('services');
	}

}
