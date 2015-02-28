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
			$reviewDetails = Input::all();
			$reviewDetails['service_id'] = $serviceId;
			$service = Service::find($serviceId);
			$serviceDetails = [];

			if(Input::has('rating'))
			{
				if($service->rate_count > 0)
				{
					$serviceDetails['rating'] = $service->rating * $service->rate_count + Input::get('rating');
					$serviceDetails['rate_count'] = $service->rate_count + 1;
					$serviceDetails['rating'] = $serviceDetails['rating'] / $serviceDetails['rate_count'];
				}
				else
				{
					$serviceDetails['rating'] = Input::get('rating');
					$serviceDetails['rate_count'] = 1;
				}
			}

			if($service->update($serviceDetails) && Review::create($reviewDetails))
			{
				return Response::json(['success' => true,
					                   'alert' => 'Successfully created review']);
			}
			else
				return Response::json(['success' => false,
					                   'alert' => 'Failed to create review']);
		}
	}

	public function update($serviceId, $id)
	{
		$review = Review::find($id);
		$service = Service::find($serviceId);
		$details = [];
		if($serviceId == $review->service_id)
		{
			if(Input::has('rating'))
			{
				$newRating = Input::get('rating');
				$oldRating = $review->rating;

				if($oldRating != -1)
					$details['rating'] = ($service->rating * $service->rate_count - $oldRating + $newRating) / $service->rate_count;
				else
				{
					$details['rate_count'] = $service->rate_count + 1;
					$details['rating'] = ($service->rating * $service->rate_count + $newRating) / $details['rate_count'];
				}
				//return Response::json($details);
			}

			if($service->update($details) && $review->update(Input::all()))
				return Response::json(['success' => true,
										'alert' => 'Successfully updated review']);
			else
				return Response::json(['success' => false,
										'alert' => 'Failed to update review']);
		}
	}


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
