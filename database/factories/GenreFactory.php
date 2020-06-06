<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Genre;

$factory->define(Genre::class, function (Faker $faker) {
    return [
        'name' => "Category ".Str::random(5),
    ];
});
