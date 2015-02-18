<?php

class ServiceType extends Eloquent {

	protected $table = 'service_types';

	protected $fillable = ['name', 'icon'];

	public static $rules = [
		'name' => 'required'
	];

}
