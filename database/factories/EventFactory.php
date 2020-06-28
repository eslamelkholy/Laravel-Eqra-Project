<?php

use App\Event;
use Faker\Generator as Faker;
use App\User;

$factory->define(Event::class, function (Faker $faker)  use ($factory) {
    $userIds = User::all()->pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'location' => $faker->name,
        'start_date' => now(),
        'end_date'   => $faker->dateTimeBetween($startDate = 'now', $endDate = '30 days'),
        'user_id' => $faker->randomElement($userIds),
        'cover_image' => null
    ];
});
