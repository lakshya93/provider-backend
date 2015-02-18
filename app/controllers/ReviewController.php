<?php

class ReviewController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($serviceId)
	{
		$reviews = Reviews::where('service_id', $serviceId)->get();
		//$reviews = Services::find($serviceId)->reviews();
		return Response::json('$reviews');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($serviceId)
	{
		$validate= Validator::make(Input::all(), Review::$rules);
		if($validate->fails())
		{
			return Response::json(['success' => false,
				                   'alert'=> 'Failed to store review',
				                   'messages' => $validate->messages()]);
		}
		else
		{
			if(Reviews::create(Input::all()))
				return Response::json(['success' => true,
					                   'alert' => 'Successfully created review']);
			else
				return Response::json(['success' => false,
					                   'alert' => 'Failed to create review']);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($serviceId, $id)
	{
		$review = Review::find($id);
		if($review)
			return Response::json($review);
		else
			return Response::json(['success' => false,
									'alert' => 'Review not found']);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($serviceId, $id)
	{
		if(Review::destroy($id))
			return Response::json(['success' => true,
									'alert' => 'Successfully deleted review']);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to delete review']);
	}


}
