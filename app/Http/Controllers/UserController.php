<?php

namespace App\Http\Controllers;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Cache;

use App\Models\Review;
use App\Models\User;
use App\Models\Favorite_world;
use App\Models\Visited_world;
use App\Models\World;

class UserController extends Controller
{
    public function userpage($user_id, Review $review, World $virtualWorld)
    {
        $user = $this->getUser('id', $user_id);
        $favorite_worlds = $this->getFavoriteWorlds($user_id);
        $visited_worlds = $this->getVisitedWorlds($user_id);
        // dump($user_id);
        // dump($favorite_worlds);
        // dump($visited_worlds);

        return view('users/userpage', compact(
            'user',
            'favorite_worlds',
            'visited_worlds',
            'virtualWorld',
            'review'
        ));
    }

    public function toggle_favorite($user_id, $world_id, Favorite_world $favorite_world)
    {
        $isAlreadlFavorited = Favorite_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->exists();

        if (!$isAlreadlFavorited) {
            $favorite_world->fill([
                'user_id' => $user_id,
                'world_id' => $world_id
            ])->save();
        } else {
            Favorite_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->delete();
        }

        $worlds_count = Favorite_world::where('world_id', $world_id)->get()->count();

        $param = [
            'favoriteCount' => $worlds_count,
        ];

        // return redirect('/users/' . $user_id);
        return response()->json($param);
    }

    public function toggle_visited($user_id, $world_id, Visited_world $visited_world)
    {
        $isAlreadlVisited = Visited_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->exists();

        if (!$isAlreadlVisited) {
            $visited_world->fill([
                'user_id' => $user_id,
                'world_id' => $world_id
            ])->save();
        } else {
            Visited_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->delete();
        }

        $worlds_count = Visited_world::where('world_id', $world_id)->get()->count();

        $param = [
            'visitedCount' => $worlds_count,
        ];

        // return redirect('/users/' . $user_id);
        return response()->json($param);
    }

    private function getUser($columnName, $columnValue)
    {
        try {
            $user = User::where($columnName, $columnValue)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $user = new User();
        }
        return $user;
    }

    private function getFavoriteWorlds($user_id)
    {
        try {
            $world_ids = Favorite_world::where(column: "user_id", operator: $user_id)->get();
            $worlds = [];
            $client = new Client();
            foreach ($world_ids as $world_id) {
                array_push($worlds, $this->getWorldByID($world_id->world_id, $client));
            }
        } catch (ModelNotFoundException $e) {
            return null;
        }
        return $worlds;
    }

    private function getVisitedWorlds($user_id)
    {
        try {
            $world_ids = Visited_world::where(column: "user_id", operator: $user_id)->get();
            $worlds = [];
            $client = new Client();
            foreach ($world_ids as $world_id) {
                array_push($worlds, $this->getWorldByID($world_id->world_id, $client));
            }
        } catch (ModelNotFoundException $e) {
            return null;
        }
        return $worlds;
    }

    private function getWorldByID($world_id, $client)
    {
        $cookieJar = CookieJar::fromArray([
            'auth' => Cache::get('authcookieJar')->toArray()[0]["Value"]
        ], 'vrchat.com');

        $url = 'https://api.vrchat.com/api/1/worlds/' . $world_id;

        if (!$client) {
            $client = new Client();
        }

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
