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
			if(Input::hasFile('photo'))
			{
				$file = Input::file('photo');
				$extension = $file->getClientOriginalExtension();
				$fileName = str_random(16) . '.' . $extension;
				$destinationPath = 'uploads/images';
				$details['photo'] = $fileName;

				if(!($file->move($destinationPath, $fileName)))
				{
					return Response::json(['success' => false,
											'alert' => 'Failed to upload image']);
				}
			}

			if(User::create($details))
			{
				return Response::json(['success' => true,
										'alert' => 'Successfully created user']);
			}
			else
			{
				if(Input::has('image'))
					File::delete($destinationPath, $fileName);
				return Response::json(['success' => false,
										'alert' => 'Failed to create user']);
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

		$messages = [];
		$passwordFlag = 0;

		//upload new image and delte old one
		if(Input::hasFile('photo'))
		{
			$file = Input::file('photo');
			$extension = $file->getClientOriginalExtension();
			$destinationPath = 'uploads/images';

			$oldFileName = $user->photo;

			$newFileName = str_random(16) . '.' . $extension;
			$details['photo'] = $newFileName;
			if(($file->move($destinationPath, $newFileName)))
			{
				File::delete($destinationPath, $oldFileName);
			}
			else
			{
				array_push($messages, 'Failed To upload photo');
				$details['photo'] = $oldFileName;
			}
		}

		//change password
		if(Input::has('old_password') && Input::has('new_password'))
		{
			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);		//requires email to update password
			if($validate->fails())
			{
				array_push($messages, 'Password must have a minimum length of 4 characters');
				// return Response::json(['success' => false,
				// 						'alert' => 'Password must have a minimum length of 4 characters']);
			}
			else
			{
				$credentials = ['email' => $user['email'],
								'password' => $details['old_password']];
				if(Auth::validate($credentials))
				{
					$details['password'] = Hash::make(Input::get('new_password'));
					// return Response::json(['success' => false,
					// 						'alert' => 'Old password does not match']);
				}
				else
				{
					array_push($messages, 'Incorrect Password');
				}
			}
		}

		if(Input::has('new_email'))
		{
			$validate = Validator::make(Input::all(), User::$emailUpdateRules);
			if($validate->fails())
			{
				array_push($messages, 'Email ID not unique');
			}
			else
			{
				$details['email'] = Input::get('new_email');
			}
		}

		if($user->update($details))
		{
			$updatedUser = User::find($user->id);
			return Response::json(['success' => true,
									'alert' => $messages,
									'user' => $updatedUser]);
		}
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
			$user = User::where('email', $credentials['email'])->first();
			return Response::json(['success' => true,
									'user' => $user]);
		}
		else
			return Response::json(['success' => false,
									'alert' => 'Invalid Credentials']);
	}

	public function logout()
	{
		Auth::logout();
		return Response::json(['success' => true,
								'alert' => 'Logged out']);
	}

}
