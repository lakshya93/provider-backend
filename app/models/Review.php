<?php

class Review extends Eloquent {

	protected $table = 'reviews';

	protected $fillable = ['user_id', 'service_id', 'description', 'rating'];

	public static $rules = [
		'user_id' => 'required',
		'description' => 'required',
		'rating' => 'numeric | digits:1 '
	];

	public function service()
	{
		return $this->belongsTo('Service');
	}

}
