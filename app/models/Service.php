<?php

class Service extends Eloquent {

	protected $table = 'services';

	protected $fillable = ['user_id', 'service_type_id', 'rating', 'rate_count', 'name', 'address',
		'mobile', 'landline', 'zipcode', 'city', 'gps_latitude', 'gps_longitude'];

	public static $rules = [
		'user_id' => 'required',
		'service_type_id' => 'required',
		'name' => 'required',
		'mobile' => 'numeric | digits:10',
		'landline' => 'numeric | digits:11',
		'zipcode' => 'numeric | digits:6'
	];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function requesters()
	{
		return $this->belongsToMany('User', 'requests');
	}

	public function reviews()
	{
		return $this->hasMany('Review');
	}

	public function images()
	{
		return $this->hasMany('Image');
	}
}
