<?php

namespace App\Library\Facebook;

use App\Review;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FacebookApiRequest
{
    public function updateReviews()
    {
        Log::info("Updating Facebook reviews");
        $page_id = config('facebook.page_id');

        $pageAccessToken = $this->getPageAccessToken($page_id);

        $reviews = $this->getPageReviews($pageAccessToken, $page_id);

        $this->saveReviews($reviews);
    }

    public function getPageAccessToken(string $page_id)
    {
        $FbApi = resolve('Facebook\Facebook');
        $request = $FbApi->request('GET', '/'. $page_id .'/?fields=access_token', [
            'access_token' => env("FACEBOOK_DEFAULT_ACCESS_TOKEN")
        ]);
        $response = $FbApi->getClient()->sendRequest($request);  //Wrap in try catch
        return collect($response->getDecodedBody())
                ->get('access_token');
    }

    public function getPageReviews(string $pageAccessToken, string $page_id) : Collection
    {
        $FbApi = resolve('Facebook\Facebook');
        $request = $FbApi->request('GET', '/'. $page_id .'/ratings?fields=created_time,has_rating,has_review,rating,recommendation_type,review_text,reviewer', [
            'access_token' => $pageAccessToken
        ]);
        $response = $FbApi->getClient()->sendRequest($request); //Wrap in try catch
        return collect($response->getDecodedBody())
                ->flatten(1);
    }

    public function saveReviews($reviews)
    {
        //Get all the reviews id's in the DB
        $reviewer_times = Review::pluck('created_time');

        foreach ($reviews as $review){
            //Check if the necessary data exists
            if((!empty($review['created_time'])) && (!empty($review['recommendation_type'])) && (!empty($review['review_text']))){
                //Make sure its a positive review and its not a duplicate
                if((!$reviewer_times->contains($review['created_time'])) && ($review['recommendation_type'] === 'positive')){
                    Review::create([
                        'name' => (!empty($review['reviewer']['name'])) ? $review['reviewer']['name'] : null,
                        'created_time' => $review['created_time'],
                        'message' => $review['review_text']
                    ]);
                }
            }
        }
        Log::info("Reviews saved for ". Carbon::now()->toDateString());
    }
}