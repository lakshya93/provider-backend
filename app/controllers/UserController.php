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
			if(Input::hasFile('image'))
			{
				$file = Input::file('image');
				$extension = $file->getClientOriginalExtension();
				$fileName = str_random(16) . '.' . $extension;
				$destinationPath = 'uploads/images';
				$details['photo'] = $fileName;

				if(($file->move($destinationPath, $fileName)))
				{
					if(User::create($details))
						return Response::json(['success' => true,
												'alert' => 'Successfully created user']);
					else
						return Response::json(['success' => false,
												'alert' => 'Failed to create user']);
				}
				else
				{
					return Response::json(['success' => false,
											'alert' => 'Failed to upload image']);
				}
			}



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

		$imageFlag = 0;
		$passwordFlag = 0;

		//upload new image and delte old one
		if(Input::hasFile('image'))
		{
			$file = Input::file('image');
			$extension = $file->getClientOriginalExtension();
			$destinationPath = 'uploads/images';

			$oldFileName = $user->photo;

			$newfileName = str_random(16) . '.' . $extension;
			$details['photo'] = $newfileName;
			if(($file->move($destinationPath, $newfileName)))
			{
				File::delete($destinationPath, $oldFileName);
			}
			else
			{
				return Response::json(['success' => false,
										'alert' => 'Failed to upload Photo']);
			}
		}

		//change password
		if(Input::has('oldPassword') && Input::has('newPassword'))
		{
			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);
			if($validate->fails)
			{
				return Response::json(['success' => fals,
										'alert' => 'Password must have a minimum length of 4 characters']);
			}
			else
			{
				$credentials = ['email' => $user['email'],
								'password' => $details['oldPassword']];
				if(!(Auth::validate($credentials)))
				{
					return Response::json(['success' => false,
											'alert' => 'Old password does not match']);
				}
				else
				{
					$details['password'] = Hash::make(Input::get('newPassword'));
				}
			}
		}

		//update only details
		if(Input::has('email'))
		{
			$validate = Validator::make(Input::all(), User::$emailUpdateRules);

			if($validate->fails())
			{
				return Response::json(['success' => false,
										'alert' => 'Email ID not unique',
			}
		}

		if($user->update($details))
			return Response::json(['success' => true,
									'alert' => 'Successfully updated details']);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to update details']);
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

	public function login()
	{
		$credentials['email'] = Input::get('email');
		$credentials['password'] = Input::get('password');
		if(Auth::attempt($credentials, true))
		{
			$user = User::where('email', $credentials['email'])->get();
			return Response::json(['success' => true.
									'user' => $user]);
		}
	}

	public function logout()
	{
		Auth::logout();
		return Response::json(['success' => true,
								'alert' => 'Logged out']);
	}

}
