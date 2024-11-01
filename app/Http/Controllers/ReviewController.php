<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Cache;

use App\Models\Review;
use App\Models\World;

use Cloudinary;
class ReviewController extends Controller
{
    // public function show()
    // {
    //     return view('review/show');
    // }

    public function create($world_id)
    {
        $world_model = new World();
        $review_model = new Review();

        $world = $this->getWorldByID($world_id);
        return view('reviews/create', compact(
            'world_model',
            'world',
            'review_model'
        ));
    }

    public function store(ReviewRequest $request)
    {
        $review_model = new Review();
        $input = $request['review'];
        if ($request->file('image')) {
            if ($request->file('image')->getError() == 0) {
                // \Debugbar::addMessage($request->file('image'));
                $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
                $input += ['image_url' => $image_url];
            }
        }
        // dump($input);
        $review_model->fill($input)->save();
        return redirect('/worlds/' . $input['world_id']);
    }

    public function edit($world_id, $review_id)
    {
        $world_model = new World();
        $review = Review::where('id', $review_id)->first();
        $world = $this->getWorldByID($world_id);
        return view('reviews/edit', compact(
            'world_model',
            'world_id',
            'world',
            'review'
        ));
    }

    public function update($review_id, ReviewRequest $request)
    {
        $review = Review::where('id', $review_id)->first();
        $input = $request['review'];
        // dump($input);
        if ($request->file('image')) {
            // \Debugbar::addMessage($request->file('image'));
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input['image_url'] = $image_url;
        }
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
