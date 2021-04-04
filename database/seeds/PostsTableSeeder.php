<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 0)
            ->create()
            ->each(function ($post) {
                $comments = factory(App\Comment::class, 0)->make();
                $post->comments()->saveMany($comments);
            }
        );
    }
}