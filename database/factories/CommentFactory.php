<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Post;
use Faker\Generator as Faker;
use App\User;

$factory->define(Comment::class, function (Faker $faker) {
    $userIds = User::all()->pluck('id')->toArray();
    $postIds = Post::all()->pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds),
        'content' => $faker->text,
    ];
});
