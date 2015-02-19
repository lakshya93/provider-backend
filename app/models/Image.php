<?php

class Image extends Eloquent {

	protected $table = 'images';

	protected $fillable = ['service_id', 'image', 'description', 'certificate'];

	public static $storeRules = [
		'service_id' => 'required',
		'image' => 'required',
		'description' => 'required',
	];

	public function service()
	{
		return $this->belongsTo('Service');
	}

}
