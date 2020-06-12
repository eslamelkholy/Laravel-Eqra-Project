<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clike;
use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Clike::class, function (Faker $faker)  use ($factory) {
    $commentIds = Comment::all()->pluck('id')->toArray();
    $userIds = User::all()->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userIds),
        'comment_id' => $faker->randomElement($commentIds)
    ];
});
