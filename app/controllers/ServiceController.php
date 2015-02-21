<?php

class ServiceController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::has('service_type'))
		{
			$serviceTypeId = ServiceType::where('name', Input::get('service_type'))->first()->id;
			$services = Service::where('service_type_id', $serviceTypeId)->get();
		}
		else if(Input::has('user_id'))
		{
			$services = Service::where('user_id', Input::get('user_id'))->get();
		}

		if($services)
			return Response::json($services);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to retrieve services']);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
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
			$details = Input::all();
			if(Service::create(Input::all()))
				return Response::json(['success' => true,
					'alert' => 'Successfully created service']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to create service']);
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
		$service = Service::find($id);
		$images = Image::where('service_id', $id)->get();
		if($images && $service)
			return Response::json([$service, $images]);
		else if($service)
			return Response::json($service);
		else
			return Response::json(['success' => false,
				'alert' => 'service not found']);
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
		if(Input::has('rating'))
		{
			$details['rating'] = $service->rating * $service->rate_count + Input::get('rating');
			$details['rate_count'] = $service->rate_count + 1;
		}
		if($service->update($details))
			return Response::json(['success' => true,
				'alert' => 'Successfully updated service']);
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
				'alert' => 'Successfully deleted service']);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to delete service']);
	}
}
