<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'rank',
        'image_url',
        'user_id',
        'world_id',
    ];

    public function getByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        // return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
        return $this->limit($limit_count)->get();
    }

    public function getWorldReviews($world_id)
    {
        $reviews = Review::where('world_id', $world_id)->get();
        return $reviews;
    }

    public function isReviewedByAuthUser($world_id): bool
    {
        //認証済ユーザーid（自身のid）を取得
        $authUserId = \Auth::id();

        //空の配列を定義。後続の処理で、いいねしたユーザーのidを全て格納していくときに使う。
        $reviewsArr = array();

        //$thisは言葉の似た通り、クラス自身を指す。具体的にはこのPostクラスをインスタンス化した際の変数のことを指す。（後続のビューで登場する$postになります）
        foreach ($this->getWorldReviews($world_id) as $review) {
            //array_pushメソッドで第一引数に配列、第二引数に配列に格納するデータを定義し、配列を作成できる。
            //今回は$likersArrという空の配列にいいねをした全てのユーザーのidを格納している。
            array_push($reviewsArr, $review->user_id);
        }

        //in_arrayメソッドを利用し、認証済ユーザーid（自身のid）が上記で作成した配列の中に存在するかどうか判定している
        if (in_array($authUserId, $reviewsArr)) {
            //存在したらいいねをしていることになるため、trueを返す
            return true;
        } else {
            return false;
        }
    }

    public function getAverageRank($world_id)
    {
        $reviews = $this->getWorldReviews($world_id);
        $averageRank = 0;
        if ($reviews->count() != 0) {
            foreach ($reviews as $review) {
                $averageRank = $averageRank + $review->rank;
            }
            $averageRank = round($averageRank / $reviews->count(), 2);
        }
        $averageRank = number_format($averageRank, 2);
        return $averageRank;
    }
}