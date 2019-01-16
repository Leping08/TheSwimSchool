<?php

namespace App\Library\Facebook;

use Facebook\Facebook;
use Illuminate\Support\Collection;

class FacebookApiRequest
{
    public function send()
    {
        $page_id = config('facebook.page_id');

        $pageAccessToken = $this->getPageAccessToken($page_id);

        return $this->getPageRatings($pageAccessToken, $page_id);

//        FB.api(
//            '/'+ page.id + '/ratings?access_token='+ page.access_token +'&limit=10?fields=reviewer{id,name,picture},rating}',
//            function(response) {
//                console.log(response);
//            }
//        );
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

    public function getPageRatings(string $pageAccessToken, string $page_id) : Collection
    {
        $FbApi = resolve('Facebook\Facebook');
        $request = $FbApi->request('GET', '/'. $page_id .'/ratings', [
            'access_token' => $pageAccessToken
        ]);
        $response = $FbApi->getClient()->sendRequest($request); //Wrap in try catch
        return collect($response->getDecodedBody())
                ->flatten(1);
    }
}