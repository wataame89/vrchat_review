<?php

namespace App\Http\Controllers;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Cache;

use App\Models\Review;
use App\Models\World;
use App\Models\User;

use Illuminate\Pagination\LengthAwarePaginator;



class WorldController extends Controller
{
    public function home()
    {
        $world_model = new World();
        $review_model = new Review();
        // Set the query parameters
        $queryParams = [
            'n' => '8',
            'sort' => 'heat',
        ];
        // dump(Cache::get('authcookieJar'));
        // dump(Cache::get('authcookieJar')->toArray());
        $status = '';
        $worlds = $this->searchWorlds($queryParams);
        // dump($worlds);
        if ($worlds) {
            $status = 'Status: VRChat authorized';
        } else {
            $status = 'Status: VRChat not authorized';
        }
        return view('worlds/home', compact(
            'worlds',
            'status',
            'world_model',
            'review_model',
        ));
    }

    public function search(Request $request)
    {
        $review_model = new Review();
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
            'n' => '36',
            // 'offset' => '999'
        ];

        $worlds = $this->searchWorlds($queryParams);
        if ($sortByReview) {
            $reviewCounts = array();
            foreach ($worlds as $world) {
                array_push($reviewCounts, $review_model->getWorldReviews($world->id)->count());
            }
            array_multisort($reviewCounts, SORT_DESC, $worlds);
        }

        // dump($worlds);
        session(['worlds' => $worlds]);
        // jsonエンコードにより、object形式を保つ
        return redirect()->route('index', [
            'search' => $search,
            'sortByReview' => $sortByReview
        ]);
    }

    public function index(Request $request)
    {
        $world_model = new World();
        $review_model = new Review();
        // $worlds = json_decode($request['worlds'], false);
        $worlds = session('worlds');
        $search = $request['search'];
        $search['keyword'] = !empty($search['keyword']) ? $search['keyword'] : "";
        $sortByReview = $request['sortByReview'];
        // dump($worlds);
        // \Debugbar::addMessage($request['worlds']);
        // \Debugbar::addMessage($search);
        foreach ($worlds as $world) {
            $world->reviewcount = Review::where("world_id", $world->id)->get()->count();
        }

        // ページネート
        $perPage = 12;  // 1ページあたりの件数
        $page = $request->input('page', 1);  // 現在のページ (クエリパラメータから取得)
        // dump($page);
        $paginatedWorlds = $this->paginateArray($worlds, $perPage, $page, ['path' => '/worlds/search']);

        $worlds = $paginatedWorlds;
        // \Debugbar::addMessage($worlds);
        // \Debugbar::addMessage($paginatedWorlds);
        return view('worlds/search', compact(
            'worlds',
            'search',
            'sortByReview',
            'world_model',
            'review_model'
        ));
    }

    public function world($world_id)
    {
        $world_model = new World();
        $review_model = new Review();
        $world = $this->getWorldByID($world_id);
        // レビュー情報の取得
        $reviews = $this->getReviews("world_id", $world_id);

        foreach ($reviews as $review) {
            $review["username"] = User::where('id', $review["user_id"])->first()["name"];
        }
        // dump($world);
        // dump($reviews);

        return view('worlds/world', compact(
            'world',
            'reviews',
            'world_model',
            'review_model'
        ));
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
