<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Cache;

use App\Models\Review;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class WorldController extends Controller
{
    public function home()
    {
        // Set the query parameters
        $queryParams = [
            'n' => '1',
        ];
        dump(Cache::get('authcookieJar'));
        $status = '';
        $worlds = $this->searchWorlds($queryParams);
        dump($worlds);
        if ($worlds) {
            $status = 'Status: VRChat authorized';
        } else {
            $status = 'Status: VRChat not authorized';
        }
        return view('worlds/home')->with('status', $status);
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
                'apiKey' => config('services.vrchat.apikey')
            ],
            'cookies' => $cookieJar,
            'auth' => [
                config('services.vrchat.username'),
                config('services.vrchat.password')
            ]
        ]);
        echo $response->getBody();

        // キャッシュを保存
        Cache::forever('authcookieJar', $cookieJar);

        return view('test/2fa');
        // return redirect('/');
    }

    public function auth_2FA_second(Request $request)
    {
        $authcode = $request['post'];
        $cookieJar = Cache::get('authcookieJar');

        $url = 'https://api.vrchat.cloud/api/1/auth/twofactorauth/emailotp/verify';

        $client = new Client();

        $response = $client->request('POST', $url, [
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

        Cache::forever('authcookieJar', $cookieJar);

        return view('test/2fa');
        // return redirect('/');
    }

    // public function worlds()
    // {
    //     // Set the query parameters
    //     $queryParams = [
    //         'featured' => 'false',
    //         'sort' => 'popularity',
    //         // 'userId' => '',
    //         'order' => 'ascending',
    //         // 'search' => '',
    //         // 'tag' => '',
    //         // 'notag' => '',
    //         'n' => '3',
    //     ];

    //     $worlds = $this->searchWorlds($queryParams);

    //     dump($worlds);



    //     return view('worlds/worlds')->with([
    //         'worlds' => $worlds
    //     ]);
    // }

    public function search(Request $request, Review $review)
    {
        $search = $request['search'];
        $sortByReview = $request['sortByReview'];

        // dump($search);

        // Set the query parameters
        $queryParams = [
            // 'featured' => 'false',
            'sort' => $search['sort'],
            // 'userId' => '',
            // 'order' => 'descending',
            'search' => $search['keyword'],
            // 'tag' => '',
            // 'notag' => '',
            'n' => '30',
        ];

        $worlds = $this->searchWorlds($queryParams);
        dump($worlds);
        session(['worlds' => $worlds]);
        // jsonエンコードにより、object形式を保つ
        return redirect()->route('index', [
            // 'worlds' => json_encode($worlds),
            'search' => $search,
            'sortByReview' => $sortByReview
        ]);
    }

    public function index(Request $request, Review $review)
    {
        // $worlds = json_decode($request['worlds'], false);
        $worlds = session('worlds');
        $search = $request['search'];
        $search['keyword'] = !empty($search['keyword']) ? $search['keyword'] : "";
        $sortByReview = $request['sortByReview'];
        dump($worlds);
        // \Debugbar::addMessage($request['worlds']);
        \Debugbar::addMessage($search);

        // ページネート
        $perPage = 10;  // 1ページあたりの件数
        $page = $request->input('page', 1);  // 現在のページ (クエリパラメータから取得)
        // dump($page);
        $paginatedWorlds = $this->paginateArray($worlds, $perPage, $page, ['path' => '/worlds/search']);

        // \Debugbar::addMessage($worlds);
        // \Debugbar::addMessage($paginatedWorlds);
        return view('worlds/search')->with([
            'worlds' => $paginatedWorlds,
            'search' => $search,
            'sortByReview' => $sortByReview
        ]);
    }

    public function world($world_id)
    {
        $world = $this->getWorldByID($world_id);
        // レビュー情報の取得
        $reviews = $this->getReviews("world_id", $world_id);

        dump($world);
        dump($reviews);

        return view('worlds/world')->with([
            'world' => $world,
            'reviews' => $reviews
        ]);
    }

    private function getReviews($columnName, $columnValue)
    {
        try {
            $reviews = Review::where($columnName, $columnValue)->get();
        } catch (ModelNotFoundException $e) {
            return null;
        }
        return $reviews;
    }
    private function searchWorlds($queryParams)
    {
        $cookieJar = CookieJar::fromArray([
            'auth' => Cache::get('authcookieJar')->toArray()[0]["Value"]
        ], 'vrchat.com');

        $url = 'https://api.vrchat.com/api/1/worlds';

        $client = new Client();

        try {
            $response = $client->request('GET', $url, [
                'cookies' => $cookieJar,
                'query' => $queryParams
            ]);
        } catch (Exception $e) {
            dump($e);
            return null;
        }

        $worlds = json_decode($response->getBody());

        return $worlds;
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

    function paginateArray(array $items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        // 配列を現在のページに合わせてスライス
        $itemsForCurrentPage = array_slice($items, ($page - 1) * $perPage, $perPage);

        // \Debugbar::addMessage($itemsForCurrentPage);
        // ページネーターを生成
        return new LengthAwarePaginator(
            $itemsForCurrentPage, // 現在のページのアイテム
            count($items),        // 全アイテム数
            $perPage,             // 1ページあたりのアイテム数
            $page,                // 現在のページ
            $options              // オプション (例えばURL設定)
        );
    }
}
