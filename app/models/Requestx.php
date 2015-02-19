<?php

class Requestx extends Eloquent {

	protected $table = 'requests';

	protected $fillable = ['user_id', 'service_id', 'status'];

	public static $storeRules = [
		'user_id' => 'required',
		'service_id' => 'required'
	];

	public static $updateRules = [
		'status' => 'required'
	];
}
