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
            'title' => 'test1',
            'body' => 'body1',
            'rank' => 4,
            'world_id' => 'wrld_414a0c26-db5c-4077-93ab-c14c921f4e07',
            'user_id' => 1,
            'liked' => 0,
            'disliked' => 0,
            'reported' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('reviews')->insert([
            'title' => 'test2',
            'body' => 'body2',
            'rank' => 2,
            'world_id' => 'wrld_414a0c26-db5c-4077-93ab-c14c921f4e07',
            'user_id' => 3,
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

        DB::table('favorite_worlds')->insert([
            'user_id' => 1,
            'world_id' => 'wrld_12f8147c-b485-4d2b-93cc-96f717ddca53',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('visited_worlds')->insert([
            'user_id' => 1,
            'world_id' => 'wrld_b32319ba-c2b7-4dab-baab-ef3f62d148b5',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
