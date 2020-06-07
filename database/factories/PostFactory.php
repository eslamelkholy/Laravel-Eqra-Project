<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker)  use ($factory) {
    return [
        'body_content' => $faker->paragraph,
        'user_id' => $faker->randomNumber(2),
        // use App\User;
        // use Faker\Generator as Faker;
        // use Illuminate\Support\Str;
        // use App\Post;
        // /*
        // |--------------------------------------------------------------------------
        // | Model Factories
        // |--------------------------------------------------------------------------
        // |
        // | This directory should contain each of the model factory definitions for
        // | your application. Factories provide a convenient way to generate new
        // | model instances for testing / seeding your application's database.
        // |
        // */

        // $factory->define(Post::class, function (Faker $faker) {
        //     $userIds = User::all()->pluck('id')->toArray();
        //     return [
        //         'body_content' => Str::random(100),
        //         'user_id' => $faker->randomElement($userIds)
    ];
});
