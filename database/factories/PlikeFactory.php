<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Plike;
use Faker\Generator as Faker;

$factory->define(Plike::class, function (Faker $faker) use ($factory) {
    return [
        'user_id' => $factory->create(App\User::class)->id,
        'post_id' => 1
    ];
});
