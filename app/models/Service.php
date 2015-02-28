<?php

class Service extends Eloquent {

	protected $table = 'services';

	protected $fillable = ['user_id', 'service_type_id', 'rating', 'rate_count', 'name', 'address',
		'mobile', 'landline', 'zipcode', 'city'];

	public static $rules = [
		'user_id' => 'required',
		'service_type_id' => 'required',
		'name' => 'required',
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
