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

	protected $fillable = ['id', 'first_name', 'last_name','email', 'password', 'dob',
		'photo', 'address', 'mobile', 'landline', 'zipcode', 'city'];

	public static $storeRules = [
		'first_name' => 'required',
		'last_name' => 'required',
		'email' => 'required | unique:users,email',
		'password' => 'required | min:3'
	];

	public static $newPasswordUpdateRules = [
			'email' => 'unique:users,email',
			'oldPassword' => 'required | min:3',
			'newPassword' => 'required | min:3'
		];

	public static $emailUpdateRules = [
			'email' => 'unique:users,email',
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
