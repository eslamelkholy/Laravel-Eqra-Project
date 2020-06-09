<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plike;
use App\Post;
use App\User;

use Faker\Generator as Faker;

$factory->define(Plike::class, function (Faker $faker) use ($factory) {
    $userIds = User::all()->pluck('id')->toArray();
    $postIds = Post::all()->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        'post_id' => $faker->randomElement($postIds)
    ];
});
