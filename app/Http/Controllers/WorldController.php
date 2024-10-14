<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;




class WorldController extends Controller
{
    public function home()
    {
        $username = config('services.vrchat.username');
        $password = config('services.vrchat.password');
        $apikey = config('services.vrchat.apikey');

        // クライアントインスタンス生成
        $client = new Client(
            // ['verify' => config('app.env') !== 'local','cookies' => true],
        );

        $jar = new CookieJar();

        // GET通信するURL
        $url = 'https://api.vrchat.cloud/api/1/auth/user';
        // $url = 'https://vrchat.com/api/1/auth/exists?email=wataame200189@yahoo.co.jp';
        // $url = 'https://umayadia-apisample.azurewebsites.net/api/persons';

        // リクエスト送信と返却データの取得
        // User-Agent設定が適切でない場合、403エラーが発生する
        $response = $client->request('GET', $url, [
                'headers' => [
                    "User-Agent" => $username
                ],
                'data' => [
                    'apiKey'=>$apikey
                ], 
                'cookies' => $jar,
                'auth' => [$username, $password]
                ]
        );
        $response->getBody();
        $cookies = $jar->toArray();

        // print_r($jar->toArray());
        // $this->authcookie = $cookies[0]["Value"];
        // $this->authcookie = new CookieJar();
        // $this->authcookie = $jar;
        // print_r($this->authcookie->toArray());
        // echo $authcookie = $cookies['value'];
        // $questions = json_decode($response->getBody(), true);

        // print($cookies[0]["Value"]);
        session(['key' => $cookies[0]["Value"]]);

        return view('worlds/home');
    }

    public function auth(Request $request){
        $code = $request['post'];
        $authcookie = session('key');
        $username = config('services.vrchat.username');

        // print($code);
        // print($authcookie);
        // $a=$this->authcookie->toArray();
        // var_dump($a[0]["Value"]);
        // echo '<script>';
        // echo 'console.log('. json_encode( $code ) .')';
        // echo '</script>';
        
        $cookieJar = CookieJar::fromArray([
            'auth' => $authcookie
        ], 'api.vrchat.cloud');
        
        $url = 'https://api.vrchat.cloud/api/1/auth/twofactorauth/emailotp/verify';

        $client = new Client();
        // $response = $client->request(
        //     'POST',
        //     $url,
        //     ['cookies'=>$cookieJar,'code'=>$code]
        // );


        $response = $client->request('POST', $url,[
            'headers' => [
                'User-Agent' => $username,
                'Content-Type' => 'application/json',
            ],
            'cookies' => $cookieJar,
            'json' => [
                'code' => $code
            ]
        ]);
        echo $response->getBody();
        return view('worlds/home');
    }
    
    public function search(Request $request){
        
    }
}
