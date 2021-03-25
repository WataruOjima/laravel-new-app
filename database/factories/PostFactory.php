<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'subject' => $faker->realText(16),
        'message' => $faker->realText(200),
        'name' => $faker->name,
        'user_id' => factory(App\User::class), 
        #'category_id' => $faker->numberBetween(1,5),
    ];
});
