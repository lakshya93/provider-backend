<?php

class ServiceController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		// $user = User::find(Input::get('user_id'));
		// if(Input::has('service_type'))
		// {
		// 	$serviceTypeId = ServiceType::where('name', Input::get('service_type'))->first()->id;
		// 	$services = Service::where('service_type_id', $serviceTypeId)->get();
		// }
		/*else>*/ if(Input::has('my_services'))
		{
			// $services = Service::where('user_id', Input::get('user_id'))->get();
			$services = Service::where('user_id', $user->id)->get();

		}
		//remove this else after testing
		else
			$services = Service::all();

		foreach($services as $service)
		{
			$serviceType = ServiceType::find($service->service_type_id);
			$service->images = Image::where('service_id', $service->id)->get();
			$service->range = GPS::calcDistance($user->gps_latitude, $user->gps_longitude, $service->gps_latitude, $service->gps_longitude);
			$service->service_type_name = $serviceType->name;
			$service->service_type_icon = $serviceType->icon;
		}

		if($services)
			return Response::json($services);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to retrieve services']);
	}


	public function store()
	{
		$validate = Validator::make(Input::all(), Service::$rules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
									'alert' => 'Failed to validate',
									'messages' => $validate->messages()]);
		}
		else
		{
			// $details = Input::all();
			if(Service::create(Input::all()))
				return Response::json(['success' => true,
										'alert' => 'Service created']);
			else
				return Response::json(['success' => false,
										'alert' => 'Failed to create service']);
		}
	}


	public function show($id)
	{
		$service = Service::find($id);
		$images = Image::where('service_id', $id)->get();
		if($images && $service)
			return Response::json([$service, $images]);
		else if($service)
			return Response::json($service);
		else
			return Response::json(['success' => false,
									'alert' => 'Service not found']);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$service = Service::find($id);
		$details = Input::all();

		if($service->update($details))
			return Response::json(['success' => true,
				'alert' => 'Service updated']);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to update service']);

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(Service::destroy($id))
			return Response::json(['success' => true,
				'alert' => 'Deleted service']);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to delete service']);
	}
}
