<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker)  use ($factory) {
    return [
        'body_content' => $faker->paragraph,
        'user_id' => $faker->randomNumber(2),
    ];
});
