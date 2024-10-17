<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;




class WorldController extends Controller
{
    public function home()
    {
        return view('worlds/home');
    }

    public function auth_2FA_first()
    {
        $username = config('services.vrchat.username');
        $password = config('services.vrchat.password');
        $apikey = config('services.vrchat.apikey');

        // クライアントインスタンス生成
        $client = new Client();
        $cookieJar = new CookieJar();

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
                'cookies' => $cookieJar,
                'auth' => [$username, $password]
                ]
        );
        echo $response->getBody();
        // $cookies = $cookieJar->toArray();
        
        // dump($response);
        // dump($response_body);
        // dump($cookies);

        // print_r($cookieJar->toArray());
        // $this->authcookie = $cookies[0]["Value"];
        // $this->authcookie = new CookieJar();
        // $this->authcookie = $cookieJar;
        // print_r($this->authcookie->toArray());
        // echo $authcookie = $cookies['value'];
        // $questions = json_decode($response->getBody(), true);

        // print($cookies[0]["Value"]);
        session(['authcookie' => $cookieJar]);

        return view('test/2fa');
        // return redirect('/');
    }

    public function auth_2FA_second(Request $request){
        $authcode = $request['post'];
        $authcookie = session('authcookie');
        // $username = config('services.vrchat.username');

        // print($authcode);
        // print($authcookie);
        // $a=$this->authcookie->toArray();
        // var_dump($a[0]["Value"]);
        // echo '<script>';
        // echo 'console.log('. json_encode( $authcode ) .')';
        // echo '</script>';
        
        // $cookieJar = CookieJar::fromArray([
        //     'auth' => $authcookie
        // ], 'api.vrchat.cloud');
        
        $url = 'https://api.vrchat.cloud/api/1/auth/twofactorauth/emailotp/verify';

        $client = new Client();

        $response = $client->request('POST', $url,[
            'headers' => [
                'User-Agent' => config('services.vrchat.username'),
                'Content-Type' => 'application/json',
            ],
            'cookies' => $authcookie,
            'json' => [
                'code' => $authcode
            ]
        ]);
        echo $response->getBody();
        
        dump($response);
        dump($response->getBody());
        dump($authcookie);

        
        session(['authcookieJar' => $authcookie]);

        return view('test/2fa');
        // return redirect('/');
    }
    
    public function world()
    {
        $username = config('services.vrchat.username');
        $authcookie = session('authcookieJar');
        $apikey = config('services.vrchat.apikey');
        
        // $authcookie->clear("twoFactorAuth");
        // dump($authcookie);
        $a = $authcookie->toArray();
        // dump($a);
        // echo $b = $a[0]["Value"];

        $cookieJar = CookieJar::fromArray([
            'auth' => $a[0]["Value"]
        ], 'vrchat.com');
        
        // $cookieJar =  new CookieJar();
        // $cookieJar[]
        \Debugbar::addMessage($authcookie);

        // dump($cookieJar);

        $url = 'https://api.vrchat.com/api/1/worlds';

        $client = new Client();

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

        $response = $client->request('GET', $url,[
            // 'headers' => [
            //     'User-Agent' => config('services.vrchat.username'),
            //     'Content-Type' => 'application/json',
            // ],
            // 'data' => [
            //     'apiKey'=>$apikey
            // ], 
            'cookies' => $cookieJar,
            'query' => $queryParams
        ]);
        echo $response->getBody();
        dd("Success");
        
        
        return view('worlds/worlds')->with([
            // 'posts' => $post->getPaginateByLimit(10),
            // 'questions' => $questions['questions'],
        ]);
    }
    
    public function search(Request $request){
        
    }
}
