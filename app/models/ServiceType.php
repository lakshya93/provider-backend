<?php

class ServiceType extends Eloquent {

	protected $table = 'service_types';

	protected $fillable = ['id', 'name', 'icon'];

	public static $rules = [
		'name' => 'required'
	];

}
