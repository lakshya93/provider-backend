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
			$table->float('rating');
			$table->integer('rate_count')->unsigned()->default(0);

			$table->string('name');
			$table->longText('address');
			$table->string('mobile');
			$table->string('landline');
			$table->string('zipcode');
			$table->string('city');
			$table->decimal('gps_latitude',10,7);
			$table->decimal('gps_longitude',10,7);

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
