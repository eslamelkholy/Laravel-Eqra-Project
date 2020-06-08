<?php

use App\Post;
use Faker\Generator as Faker;
use App\User;
$factory->define(Post::class, function (Faker $faker)  use ($factory) {
    $userIds = User::all()->pluck('id')->toArray();
    return [
        'body_content' => Str::random(100),
        'user_id' => $faker->randomElement($userIds)
    ];
});
