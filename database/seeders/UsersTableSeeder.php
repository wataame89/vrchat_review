<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // 'name' => 'test',
            // 'email' => 'aiu@mail.com',
            // 'password' => 'aiu',
            // 'image_path' => 'https',
            // 'vrchat_id' => 'aiuro_aiu',
            // 'created_at' => new DateTime(),
            // 'updated_at' => new DateTime(),
        ]);
        
        DB::table('reviews')->insert([
            'title' => 'testtitle',
            'body' => 'aiueoaiueo',
            'rank' => 4,
            'world_id' => 'ai_ueo',
            'user_id' => 1,
            'liked' => 0,
            'disliked' => 0,
            'reported' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('images')->insert([
            'review_id' => 1,
            'image_path' => 'aiueoaiueo',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('favorite')->insert([
            'user_id' => 1,
            'world_id' => 'aiueoaiueo',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('visited')->insert([
            'user_id' => 1,
            'world_id' => 'aiueoaiueo',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
