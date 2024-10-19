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
        'user_id',
        'world_id',
    ];

    public function getByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        // return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
        return $this->limit($limit_count)->get();
    }
}