<?php

class RequestController extends \BaseController {

	//remove index() after testing
	public function index()
	{
		if(Input::has('sent_requests'))
		{
			$userId = Input::get('user_id');
			$requests = Requestx::where('user_id', $userId)->get();
			if($requests) {
				foreach($requests as $request) {
					$request['service'] = Service::find($request->service_id);

					$user = User::find($request['service']->user_id);
					$request['service']->user_name = $user->first_name . ' ' . $user->last_name;		//user_name => provider's name

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

					$request['user'] = User::find($request->user_id);		// user_name => requester's name

					$service = Service::find($request->service_id);
					$request['business_name'] = $service->business_name;
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
			$details['status'] = 'pending';
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
					'alert' => 'Successfully updated request']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to update request']);
		}
	}

	public function sentRequests()			//you are the one who sent request for a service
	{
		$userId = Input::get('user_id');
		$requests = Requestx::where('user_id', $userId)->get();
		if($requests) {
			foreach($requests as $request) {
				$request['service'] = Service::find($request->service_id);

				$user = User::find($request['service']->user_id);
				$request['service']->user_name = $user->first_name . ' ' . $user->last_name;		//user_name => provider's name

			}
			return Response::json($requests);
		}
	}


	public function receivedRequests()
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

				$request['user'] = User::find($request->user_id);		// user_name => requester's name

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
		if(Requestx::destroy($id))
			return Response::json(['success' => true,
									'alert' => 'Request deleted']);
		else
			return Response::json(['success' => true,
									'alert' => 'Request deleted']);

	}


}
