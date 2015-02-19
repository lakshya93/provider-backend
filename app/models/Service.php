<?php

class Service extends Eloquent {

	protected $table = 'services';

	protected $fillable = ['user_id', 'service_type_id', 'rating', 'business_name', 'business_address',
		'business_mobile', 'business_landline', 'business_zipcode', 'business_city'];

	public static $rules = [
		'user_id' => 'required',
		'service_type_id' => 'required',
		'business_name' => 'required',
	];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function requesters()
	{
		return $this->belongsToMany('User', 'requests');
	}
}
