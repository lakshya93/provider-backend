<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return Response::json($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validate = Validator::make(Input::all(), User::$storeRules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
									'alert' => 'Failed to validate',
									'messages' => $validate->messages()]);
		}
		else
		{
			$details = Input::all();
			$details['password'] = Hash::make(Input::get('password'));


			if(User::create($details))
				return Response::json(['success' => true,
										'alert' => 'Successfully created user']);
			else
				return Response::json(['success' => false,
										'alert' => 'Failed to create user']);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		if($user)
			return Response::json($user);
		else
			return Response::json(['success' => false,
									'alert' => 'User not found']);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$details = Input::all();
		$user = User::find($id);

		//change password
		if(Input::has('oldPassword') && Input::has('newPassword'))
		{
			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);

			$credentials = ['email' => $user['email'],
							'password' => $details['oldPassword']];
			if(!(Auth::validate($credentials)))
			{
				return Response::json(['success' => false,
										'alert' => 'Old password does not match']);
			}
			else
			{
				$details['email'] = Input::get('email');
				$details['password'] = Hash::make(Input::get('newPassword'));
				if($user->update($details))
					return Response::json(['success' => true,
											'alert' => 'Successfully updated password']);
				else
					return Response::json(['success' => false,
											'alert' => 'Failed to update password']);
			}
		}

		//update only details
		else
		{
			$validate = Validator::make(Input::all(), User::$emailUpdateRules);

			if($validate->fails())
			{
				return Response::json(['success' => false,
										'alert' => 'Validate failed',
										'messages' => $validate->messages()]);
			}

			else
			{
				if($user->update($details))
					return Response::json(['success' => true,
											'alert' => 'Successfully updated details']);
				else
					return Response::json(['success' => false,
											'alert' => 'Failed to update details']);
			 }
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(User::destroy($id))
			return Response::json(['success' => true,
									'alert' => 'Successfully deleted user']);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to delete user']);
	}


}
