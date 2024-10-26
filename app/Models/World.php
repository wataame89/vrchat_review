<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    use HasFactory;

    //post_likesテーブルへのリレーションメソッド。Postモデルのインスタンス＄postに、$post->likes->count()とすると記事のいいね数を取得できるようになった。
    public function favoriteWorlds($world_id)
    {
        $favorited_worlds = Favorite_world::where('world_id', $world_id)->get();
        return $favorited_worlds;
    }
    //自身がいいねしているのかどうか判定するメソッド（しているならtrue,していないならfalseを返す）
    public function isFavoritedByAuthUser($world_id): bool
    {
        //認証済ユーザーid（自身のid）を取得
        $authUserId = \Auth::id();

        //空の配列を定義。後続の処理で、いいねしたユーザーのidを全て格納していくときに使う。
        $likersArr = array();

        //$thisは言葉の似た通り、クラス自身を指す。具体的にはこのPostクラスをインスタンス化した際の変数のことを指す。（後続のビューで登場する$postになります）
        foreach ($this->favoriteWorlds($world_id) as $favoriteWorld) {
            //array_pushメソッドで第一引数に配列、第二引数に配列に格納するデータを定義し、配列を作成できる。
            //今回は$likersArrという空の配列にいいねをした全てのユーザーのidを格納している。
            array_push($likersArr, $favoriteWorld->user_id);
        }

        //in_arrayメソッドを利用し、認証済ユーザーid（自身のid）が上記で作成した配列の中に存在するかどうか判定している
        if (in_array($authUserId, $likersArr)) {
            //存在したらいいねをしていることになるため、trueを返す
            return true;
        } else {
            return false;
        }
    }
    //post_likesテーブルへのリレーションメソッド。Postモデルのインスタンス＄postに、$post->likes->count()とすると記事のいいね数を取得できるようになった。
    public function visitedWorlds($world_id)
    {
        $visitedd_worlds = Visited_world::where('world_id', $world_id)->get();
        return $visitedd_worlds;
    }
    //自身がいいねしているのかどうか判定するメソッド（しているならtrue,していないならfalseを返す）
    public function isVisitedByAuthUser($world_id): bool
    {
        //認証済ユーザーid（自身のid）を取得
        $authUserId = \Auth::id();

        //空の配列を定義。後続の処理で、いいねしたユーザーのidを全て格納していくときに使う。
        $likersArr = array();

        //$thisは言葉の似た通り、クラス自身を指す。具体的にはこのPostクラスをインスタンス化した際の変数のことを指す。（後続のビューで登場する$postになります）
        foreach ($this->visitedWorlds($world_id) as $visitedWorld) {
            //array_pushメソッドで第一引数に配列、第二引数に配列に格納するデータを定義し、配列を作成できる。
            //今回は$likersArrという空の配列にいいねをした全てのユーザーのidを格納している。
            array_push($likersArr, $visitedWorld->user_id);
        }

        //in_arrayメソッドを利用し、認証済ユーザーid（自身のid）が上記で作成した配列の中に存在するかどうか判定している
        if (in_array($authUserId, $likersArr)) {
            //存在したらいいねをしていることになるため、trueを返す
            return true;
        } else {
            return false;
        }
    }
}
