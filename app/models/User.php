<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = ['first_name', 'last_name','email', 'password', 'photo', 'address',
		'mobile', 'landline', 'zipcode', 'city', 'gps_latitude', 'gps_longitude'];

	public static $storeRules = [
		'first_name' => 'required',
		'last_name' => 'required',
		'email' => 'required | unique:users,email',
		'password' => 'required | min:4',

		'mobile' => 'numeric | digits:10',
		'landline' => 'numeric | digits:11',
		'zipcode' => 'numeric | digits:6'
	];

	public static $newPasswordUpdateRules = [
			'email' => 'required',
			'old_password' => 'required ',
			'new_password' => 'required | min:4'
		];

	public static $emailUpdateRules = [
			'new_email' => 'unique:users,email',
			'new_email' => 'required'
		];

	protected $hidden = array('password', 'remember_token');

	public function services()
	{
		return $this->hasMany('Service');
	}

	public function requests()
	{
		return $this->belongsToMany('Service', 'requests');
	}
}
