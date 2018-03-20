<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->streetAddress,
        'country' => $faker->country,
        'city' => $faker->city,
    ];
});
