<?php

class Review extends Eloquent {

	protected $table = 'reviews';

	protected $fillable = ['user_id', 'service_id', 'description'];

	public static $rules = [
		'user_id' => 'required',
		'description' => 'required'
	];

	public function service()
	{
		return $this->belongsTo('Service');
	}

}
