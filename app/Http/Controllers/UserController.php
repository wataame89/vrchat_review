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

use App\Http\Controllers\WorldController;

class UserController extends Controller
{
    public function userpage($user_name)
    {
        $user_id = User::where("name", $user_name)->first()->id;
        $review_model = new Review();
        $world_model = new World();
        $user = $this->getUser('id', $user_id);
        $visited_worlds = $this->getVisitedWorlds($user_id);
        $favorite_worlds = array_udiff(
            $this->getFavoriteWorlds($user_id),
            $visited_worlds,
            function ($a, $b) {
                return $a->id <=> $b->id;
            }
        );
        $reviews = Review::where('user_id', $user_id)->get();
        foreach ($reviews as $review) {
            $review["username"] = User::where('id', $review["user_id"])->first()["name"];
        }

        // \Debugbar::addMessage($reviews);
        // dump($user_id);
        // dump($favorite_worlds);
        // dump($visited_worlds);

        return view('users/userpage', compact(
            'user',
            'favorite_worlds',
            'visited_worlds',
            'world_model',
            'reviews',
            'review_model'
        ));
    }

    public function toggle_favorite($user_id, $world_id)
    {
        $favorite_world_model = new Favorite_world();
        $isAlreadlFavorited = Favorite_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->exists();

        if (!$isAlreadlFavorited) {
            $favorite_world_model->fill([
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

    public function toggle_visited($user_id, $world_id)
    {
        $visited_world_model = new Visited_world();
        $isAlreadlVisited = Visited_world::where(column: "user_id", operator: $user_id)->where(column: "world_id", operator: $world_id)->exists();

        if (!$isAlreadlVisited) {
            $visited_world_model->fill([
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
                array_push($worlds, WorldController::getWorldByID($world_id->world_id, $client));
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
                array_push($worlds, WorldController::getWorldByID($world_id->world_id, $client));
            }
        } catch (ModelNotFoundException $e) {
            return null;
        }
        return $worlds;
    }
}
