<?php

class RequestController extends \BaseController {

	public function index()
	{
		if(Input::has('sent_requests'))
		{
			$userId = Input::get('user_id');
			$requests = Requestx::where('user_id', $userId)->get();
			if($requests) {
				foreach($requests as $request) {
					$request['service'] = Service::find($request->service_id);
					$request['service']->service_type_icon = ServiceType::find($request['service']->service_type_id)->icon;
					$request['service']->range = GPS::calcDistance($user->gps_latitude, $user->gps_longitude, $request['service']->gps_latitude, $request['service']->gps_longitude);

					// $user = User::find($request['service']->user_id);
					// $request['service']->user_name = $user->first_name . ' ' . $user->last_name;		//user_name => provider's name

				}
				return Response::json($requests);
			}
		}

		else if(Input::has('received_requests'))
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

					$service = Service::find($request->service_id);
					$request['service_name'] = $service->name;
					$request['user'] = User::find($request->user_id);		// user_name => requester's name
					$request['user']->range = GPS::calcDistance($request['user']->gps_latitude, $request['user']->gps_longitude, $service->gps_latitude, $service->gps_longitude);
				}
				return Response::json($requests);
			}
		}
		else
			return Response::json(['success' => false,
				'alert' => 'Could not retrieve requests']);
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
			$userId = Input::get('user_id');
			$serviceId = Input::get('service_id');
			$service = Service::find($serviceId);

			$details['status'] = 'pending';

			if($userId == $service->user_id)
			{
				return Response::json(['success' => false,
										'alert' => 'Cannot request for your own service!']);
			}
			if(Requestx::create($details))
				return Response::json(['success' => true,
										'alert' => 'Request sent']);
			else
				return Response::json(['success' => false,
										'alert' => 'Failed to send request']);
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
					'alert' => 'Updated request']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to update request']);
		}
	}




	// public function sentRequests()
	// {
	// 	$userId = Input::get('user_id');
	// 	$requests = Requestx::where('user_id', $userId)->get();
	// 	if($requests) {
	// 		foreach($requests as $request) {
	// 			$request['service'] = Service::find($request->service_id);
	//
	// 			$user = User::find($request['service']->user_id);
	// 			$request['service']->user_name = $user->first_name . ' ' . $user->last_name;		//user_name => provider's name
	//
	// 		}
	// 		return Response::json($requests);
	// 	}
	// }
	//
	//
	//
	// public function receivedRequests()
	// {
	// 	$userId = Input::get('user_id');
	// 	$serviceIdsObject = Service::select('id')->where('user_id', $userId)->get();
	// 	$serviceIdsArray = [];
	//
	// 	foreach($serviceIdsObject as $serviceId) {
	// 		array_push($serviceIdsArray, $serviceId['id']);
	// 	}
	//
	// 	$requests = Requestx::whereIn('service_id', $serviceIdsArray)->get();
	//
	// 	if($requests) {
	// 		foreach($requests as $request) {
	//
	// 			$request['user'] = User::find($request->user_id);		// user_name => requester's name
	//
	// 			$service = Service::find($request->service_id);
	// 			$request['service_name'] = $service->service_name;
	// 		}
	// 		return Response::json($requests);
	// 	}
	// 	else
	// 		return Response::json(['success' => false,
	// 			'alert' => 'Could not retrieve requests']);
	// }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(Requestx::destroy($id))
			return Response::json(['success' => true,
									'alert' => 'Request deleted']);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to delete review']);

	}


}
