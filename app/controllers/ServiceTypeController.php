<?php

class ServiceTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$serviceTypes = ServiceType::all();
		return Response::json($serviceTypes);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validate = Validator::make(Input::all(), ServiceType::$rules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
				'alert' => 'Failed to validate',
				'messages' => $validate->messages()]);
		}
		else
		{
			$details = Input::all();
			if(ServiceType::create(Input::all()))
				return Response::json(['success' => true,
					'alert' => 'Successfully created service_type']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to create service_type']);
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
		$service_type = ServiceType::find($id);
		if($service_type)
			return Response::json($service_type);
		else
			return Response::json(['success' => false,
				'alert' => 'service_type not found']);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$service_type = ServiceType::find($id);
		$validate = Validator::make(Input::all(), ServiceType::$rules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
				'alert' => 'Failed to validate',
				'messages' => $validate->messages()]);
		}
		else
		{
			$details = Input::all();
			if($service_type->update(Input::all()))
				return Response::json(['success' => true,
					'alert' => 'Successfully updated service_type']);
			else
				return Response::json(['success' => false,
					'alert' => 'Failed to update service_type']);
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
		if(ServiceType::destroy($id))
			return Response::json(['success' => true,
				'alert' => 'Successfully deleted service_type']);
		else
			return Response::json(['success' => false,
				'alert' => 'Failed to delete service_type']);


	}
}
