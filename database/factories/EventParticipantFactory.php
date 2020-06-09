<?php

use App\Event;
use Faker\Generator as Faker;
use App\User;
$factory->define(EventParticipant::class, function (Faker $faker)  use ($factory) {
    $userIds = User::all()->pluck('id')->toArray();
    $eventIds = Event::all()->pluck('id')->toArray();
    return [
        'name' => $faker->title,
        'state' => $faker->randomElement(['pending', 'interested', 'going']),
        'event_id' => $faker->randomElement($eventIds),
        'user_id' => $faker->randomElement($userIds),
    ];
});
