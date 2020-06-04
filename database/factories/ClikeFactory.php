<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clike;
use Faker\Generator as Faker;

$factory->define(Clike::class, function (Faker $faker)  use ($factory) {
    return [
        'user_id' => $factory->create(App\User::class)->id,
        'comment_id' => 1
    ];
});
