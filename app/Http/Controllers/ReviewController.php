<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class ReviewController extends Controller
{
    // public function show()
    // {
    //     return view('review/show');
    // }

    public function create($world_id, Review $review, World $virtualWorld)
    {
        $world = $this->getWorldByID($world_id);
        return view('reviews/create')->with([
            'virtualWorld' => $virtualWorld,
            'world' => $world,
            'review' => $review
        ]);
    }

    public function store(Request $request, Review $review)
    {
        $input = $request['review'];
        // dump($input);
        $review->fill($input)->save();
        return redirect('/worlds/' . $input['world_id']);
    }

    public function edit($world_id, $review_id)
    {
        $review = Review::where('id', $review_id)->first();
        return view('reviews/edit')->with([
            'world_id' => $world_id,
            'review' => $review
        ]);
    }

    public function update($review_id, Request $request)
    {
        $review = Review::where('id', $review_id)->first();
        $input = $request['review'];
        // dump($input);
        $review->fill($input)->save();
        return redirect('/worlds/' . $input['world_id']);
    }

    public function delete($review_id, Request $request)
    {
        $review = Review::where('id', $review_id)->first();
        $review->delete();
        return redirect('/worlds/' . $request['world_id']);
    }

    private function getWorldByID($world_id)
    {
        $cookieJar = CookieJar::fromArray([
            'auth' => Cache::get('authcookieJar')->toArray()[0]["Value"]
        ], 'vrchat.com');

        $url = 'https://api.vrchat.com/api/1/worlds/' . $world_id;

        $client = new Client();

        try {
            $response = $client->request('GET', $url, [
                'cookies' => $cookieJar,
            ]);
        } catch (Exception $e) {
            dump($e);
            return null;
        }

        $world = json_decode($response->getBody());

        return $world;
    }
}
