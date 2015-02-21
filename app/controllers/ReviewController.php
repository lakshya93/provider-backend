<?php

class ReviewController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($serviceId)
	{
		$reviews = Review::where('service_id', $serviceId)->get();
		foreach($reviews as $review)
		{
			$user = User::find($review->user_id);
			$review['user_name'] = $user->first_name . ' ' . $user->last_name;
		}
		return Response::json($reviews);
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
			if(Review::create(Input::all()))
				return Response::json(['success' => true,
					                   'alert' => 'Successfully created review']);
			else
				return Response::json(['success' => false,
					                   'alert' => 'Failed to create review']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($serviceId, $id)
	{
		$review = Review::find($id);
		if($serviceId == $review->service_id)
		{
			if(Review::destroy($id))
				return Response::json(['success' => true,
										'alert' => 'Successfully deleted review']);
			else
				return Response::json(['success' => false,
										'alert' => 'Failed to delete review']);
		}
	}


}
