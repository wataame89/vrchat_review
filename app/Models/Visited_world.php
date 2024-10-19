<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visited_world extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'world_id',
    ];
}
