<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'country' => $faker->country
    ];
});
