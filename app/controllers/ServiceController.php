<?php

class ServiceController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$services = Service::all();
		if($services)
			return Response::json($services);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to retrieve all services']);
	}

	public function indexType()
	{
		$serviceTypeId = Input::get('service_type_id');
		$services = Service::where('service_type_id', $serviceTypeId)->get();

		foreach($services as $service) {
			$service->images = $service->images();
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
			if($service->update(Input::all()))
				return Response::json(['success' => true,
					'alert' => 'Successfully updated service']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to update service']);
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
		if(Service::destroy($id))
			return Response::json(['success' => true,
				'alert' => 'Successfully deleted service']);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to delete service']);
	}
}
