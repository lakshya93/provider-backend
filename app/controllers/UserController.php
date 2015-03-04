<?php

class UserController extends \BaseController {

	public function index()
	{
		$users = User::all();
		return Response::json($users);
	}



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
											'alert' => 'Failed to upload photo']);
				}
			}

			if(User::create($details))
			{
				return Response::json(['success' => true,
										'alert' => 'Registered']);
			}
			else
			{
				if(Input::has('photo'))
					File::delete($destinationPath, $fileName);
				return Response::json(['success' => false,
										'alert' => 'Failed to register']);
			}
		}
	}



	public function show($id)
	{
		$user = User::find($id);
		if($user)
			return Response::json($user);
		else
			return Response::json(['success' => false,
									'alert' => 'User not found']);
	}



	public function update($id)
	{
		$details = Input::all();
		$user = User::find($id);

		$messages = [];
		$emailFlag = true;

		if(Input::has('new_email'))
		{
			$validate = Validator::make(Input::all(), User::$emailUpdateRules);
			if($validate->fails())
			{
				$emailFlag = false;
				// array_push($messages, 'Email ID not unique');
			}
			else
			{
				$details['email'] = Input::get('new_email');
			}
		}

		if($user->update($details))
		{
			$updatedUser = User::find($user->id);
			// array_push($messages, 'Profile updated');
			if($emailFlag)
			{
				return Response::json(['success' => true,
										'alert' => 'Profile Updated']);
			}
			else
			{
				return Response::json(['success' => true,
										'alert' => 'Profile Updated',
										'user' => $updatedUser]);
			}
		}
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to update profile']);
	}




	public function destroy($id)
	{
		if(User::destroy($id))
			return Response::json(['success' => true,
									'alert' => 'User deleted']);
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
			$user = Auth::user();
			// $user = User::where('email', $credentials['email'])->first();
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




	public function changePassword($id)
	{
		//change password
		$user = User::find($id);
		if(Input::has('old_password') && Input::has('new_password'))
		{

			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);		//requires email to update password
			if($validate->fails())
			{
				//array_push($messages, 'Password must have a minimum length of 4 characters');
				return Response::json(['success' => false,
										'alert' => $validate->messages()]);
			}
			else
			{
				$details = Input::all();
				$credentials = ['email' => $details['email'],
								'password' => $details['old_password']];
				if(Auth::validate($credentials))
				{
					$details['password'] = Hash::make(Input::get('new_password'));

					if($user->update($details))
						return Response::json(['success' => true,
												'alert' => 'Password changed']);
					else
						return Response::json(['success' => false,
												'alert' => 'Failed to change password']);

				}
				else
				{
					return Response::json(['success' => false,
											'alert' => 'Incorrect Password']);
				}
			}
		}
	}



	public function changePhoto($id)
	{
		//upload new image and delte old one
		$user = User::find($id);
		$details = [];
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
				if($user->update($details))
					return Response::json(['success' => true,
											'alert' => 'Photo changed']);
				else
					return Response::json(['success' => false,
											'alert' => 'Failed to change photo']);

			}
			else
			{
				return Response::json(['success' => false,
										'alert' => 'Failed to upload photo']);
			}
		}
	}
}
