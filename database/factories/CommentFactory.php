<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(2),
        'post_id' => 17,
        'content' => $faker->paragraph,
    ];
});
