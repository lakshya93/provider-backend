<?php

class RequestController extends \BaseController {

	public function index()
	{
		$requests = Requestx::all();
		return Response::json($requests);
	}

	public function store()
	{
		$validate = Validator::make(Input::all(), Requestx::$storeRules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
				'alert' => 'Failed to validate',
				'messages' => $validate->messages()]);
		}
		else
		{
			$details = Input::all();
			$details['status'] = 'pending';
			if(Requestx::create($details))
				return Response::json(['success' => true,
					'alert' => 'Successfully created service']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to create service']);
		}
	}

	public function update($id)
	{
		$request = Requestx::find($id);
		$validate = Validator::make(Input::all(), Requestx::$updateRules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
				'alert' => 'Failed to validate',
				'messages' => $validate->messages()]);
		}
		else
		{
			$details = Input::all();
			if($request->update($details))
				return Response::json(['success' => true,
					'alert' => 'Successfully created service']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to create service']);
		}
	}

	public function sentRequests()			//you are the one who sent request for a service
	{
		$userId = Input::get('user_id');
		$requests = Requestx::where('user_id', $userId)->get();
		if($requests) {
			foreach($requests as $request) {
				$service = Service::find($request->service_id);
				$request['business_name'] = $service->business_name;

				$user = User::find($service->user_id);
				$request['user_name'] = $user->first_name . ' ' . $user->last_name;		//user_name => provider's name

			}
			return Response::json($requests);
		}
	}


	public function recievedRequests()
	{
		$userId = Input::get('user_id');
		$serviceIdsObject = Service::select('id')->where('user_id', $userId)->get();
		$serviceIdsArray = [];

		foreach($serviceIdsObject as $serviceId) {
			array_push($serviceIdsArray, $serviceId['id']);
		}

		$requests = Requestx::whereIn('service_id', $serviceIdsArray)->get();

		if($requests) {
			foreach($requests as $request) {
				$user = User::find($request->user_id);
				$request['user_name'] = $user->first_name . ' ' . $user->last_name;		// user_name => requester's name

				$service = Service::find($request->service_id);
				$request['business_name'] = $service->business_name;
			}
			return Response::json($requests);
		}
		else
			return Response::json(['success' => false,
				'alert' => 'Could not retrieve requests']);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Requestx::destroy($id);
	}


}
