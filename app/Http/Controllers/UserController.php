<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use App\Models\Review;
use App\Models\User;
use App\Models\Favorite_world;
use App\Models\Visited_world;

class UserController extends Controller
{
    public function userpage($user_id)
    {
        $user = $this->getUser('id',$user_id);
        $favorite_worlds = $this->getFavoriteWorlds($user_id);
        $visited_worlds = $this->getVisitedWorlds($user_id);
        dump($user_id);
        dump($favorite_worlds);
        dump($visited_worlds);

        return view('users/userpage')->with([
            'user'=> $user,
            'favorite_worlds'=> $favorite_worlds,
            'visited_worlds'=> $visited_worlds
        ]);
    }
    
    public function create_favorite($user_id,$world_id,Favorite_world $favorite_world)
    {
        // dump($world_id);
        // dump($user_id);
        $isExist = Favorite_world::where(column: "user_id",operator: $user_id)->where(column: "world_id",operator: $world_id)->exists();
        
        if (!$isExist) {
            $favorite_world->fill([
                'user_id'=> $user_id,
                'world_id'=> $world_id
            ])->save();
        }
        
        return redirect('/users/' . $user_id);
    }

    public function delete_favorite($user_id,$world_id)
    {
        // dump($world_id);
        // dump($user_id);
        $target = Favorite_world::where(column: "user_id",operator: $user_id)->where(column: "world_id",operator: $world_id)->first();

        // ユーザーが存在する場合は削除
        if ($target) {
            $target->delete();
        }
        
        return redirect('/users/' . $user_id);
    }
    
    public function create_visited($user_id,$world_id,Visited_world $visited_world)
    {
        // dump($world_id);
        // dump($user_id);
        $isExist = Visited_world::where(column: "user_id",operator: $user_id)->where(column: "world_id",operator: $world_id)->exists();
        
        if (!$isExist) {
            $visited_world->fill([
                'user_id'=> $user_id,
                'world_id'=> $world_id
            ])->save();
        }
        
        return redirect('/users/' . $user_id);
    }

    public function delete_visited($user_id,$world_id)
    {
        // dump($world_id);
        // dump($user_id);
        $target = Visited_world::where(column: "user_id",operator: $user_id)->where(column: "world_id",operator: $world_id)->first();

        // ユーザーが存在する場合は削除
        if ($target) {
            $target->delete();
        }
        
        return redirect('/users/' . $user_id);
    }

    private function getUser($columnName, $columnValue){
        try{
            $user = User::where($columnName, $columnValue)->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            $user = new User();
        }
        return $user;
    }
    
    private function getFavoriteWorlds($user_id){
        try{
            $world_ids = Favorite_world::where(column: "user_id",operator: $user_id)->get();
            $worlds = [];
            foreach ($world_ids as $world_id) {
                array_push($worlds,$this->getWorldByID($world_id->world_id));
            }
        }
        catch(ModelNotFoundException $e){
            return null;
        }
        return $worlds;
    }

    private function getVisitedWorlds($user_id){
        try{
            $world_ids = Visited_world::where(column: "user_id",operator: $user_id)->get();
            $worlds = [];
            foreach ($world_ids as $world_id) {
                array_push($worlds,$this->getWorldByID($world_id->world_id));
            }
        }
        catch(ModelNotFoundException $e){
            return null;
        }
        return $worlds;
    }
    
    private function getWorldByID($world_id){
        $cookieJar = CookieJar::fromArray([
            'auth' => session('authcookieJar')->toArray()[0]["Value"]
        ], 'vrchat.com');

        $url = 'https://api.vrchat.com/api/1/worlds/'.$world_id;

        $client = new Client();
        
        try{
            $response = $client->request('GET', $url,[
                'cookies' => $cookieJar,
            ]);
        }
        catch(Exception  $e){
            dump($e);
            return null;
        }

        $world = json_decode($response->getBody());

        return $world;
    }
}
