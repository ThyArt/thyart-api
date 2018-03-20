<?php

use App\User;
use Faker\Generator as Faker;
use Faker\Provider\fr_FR\PhoneNumber;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => PhoneNumber::mobileNumber(),
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'country' => $faker->country,
        'city' => $faker->city,
    ];
});
