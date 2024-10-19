<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use App\Models\Review;


class WorldController extends Controller
{
    public function home()
    {
        return view('worlds/home');
    }

    public function auth_2FA_first()
    {
        // クライアントインスタンス生成
        $client = new Client();

        //クッキーインスタンス作成
        $cookieJar = new CookieJar();

        // GET通信するURL
        $url = 'https://api.vrchat.cloud/api/1/auth/user';

        // リクエスト送信と返却データの取得
        // User-Agent設定が適切でない場合、403エラーが発生する
        $response = $client->request('GET', $url, [
                'headers' => [
                    "User-Agent" => config('services.vrchat.username')
                ],
                'data' => [
                    'apiKey'=> config('services.vrchat.apikey')
                ], 
                'cookies' => $cookieJar,
                'auth' => [
                    config('services.vrchat.username'),
                    config('services.vrchat.password')
                ]
        ]);
        echo $response->getBody();

        //クッキーを保存
        session(['authcookieJar' => $cookieJar]);

        return view('test/2fa');
        // return redirect('/');
    }

    public function auth_2FA_second(Request $request){
        $authcode = $request['post'];
        $cookieJar = session('authcookieJar');

        $url = 'https://api.vrchat.cloud/api/1/auth/twofactorauth/emailotp/verify';

        $client = new Client();

        $response = $client->request('POST', $url,[
            'headers' => [
                'User-Agent' => config('services.vrchat.username'),
                'Content-Type' => 'application/json',
            ],
            'cookies' => $cookieJar,
            'json' => [
                'code' => $authcode
            ]
        ]);
        echo $response->getBody();
        
        // dump($response);
        // dump($response->getBody());
        // dump($cookieJar);

        session(['authcookieJar' => $cookieJar]);

        return view('test/2fa');
        // return redirect('/');
    }
    
    public function worlds()
    {
        // Set the query parameters
        $queryParams = [
            'featured' => 'false',
            'sort' => 'popularity',
            // 'userId' => '',
            'order' => 'ascending',
            // 'search' => '',
            // 'tag' => '',
            // 'notag' => '',
            'n' => '3',
        ];

        $worlds = $this->searchWorlds($queryParams);

        dump($worlds);
        
        
        
        return view('worlds/worlds')->with([
           'worlds' =>  $worlds
        ]);
    }
    
    public function search(Request $request, Review $review){
        $serchname = $request['post'];
        
        
        // Set the query parameters
        $queryParams = [
            'featured' => 'false',
            'sort' => 'popularity',
            // 'userId' => '',
            'order' => 'ascending',
            'search' => $serchname,
            // 'tag' => '',
            // 'notag' => '',
            'n' => '30',
        ];

        $worlds = $this->searchWorlds($queryParams);

        dump($worlds);
        
        return view('worlds/worlds')->with([
            'worlds' =>  $worlds
         ]);
    }

    public function world($world_id)
    {
        $world =  $this->getWorldByID($world_id);
        // レビュー情報の取得
        $reviews = $this->getReviews("world_id",$world_id);

        dump($world);
        dump($reviews);
        
        return view('worlds/world')->with([
           'world' =>  $world,
           'reviews' =>  $reviews
        ]);
    }

    private function getReviews($columnName, $columnValue){
        try{
            $reviews = Review::where($columnName,$columnValue)->get();
        }
        catch(ModelNotFoundException $e){
            return null;
        }
        return $reviews;
    }
    private function searchWorlds($queryParams){
        $cookieJar = CookieJar::fromArray([
            'auth' => session('authcookieJar')->toArray()[0]["Value"]
        ], 'vrchat.com');

        $url = 'https://api.vrchat.com/api/1/worlds';

        $client = new Client();
        
        try{
            $response = $client->request('GET', $url,[
                'cookies' => $cookieJar,
                'query' => $queryParams
            ]);
        }
        catch(Exception  $e){
            dump($e);
            return null;
        }

        $worlds = json_decode($response->getBody());

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
