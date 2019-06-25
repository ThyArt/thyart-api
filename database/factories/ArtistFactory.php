<?php

use Faker\Generator as Faker;
use App\Gallery;

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'gallery_id' => Gallery::all()->random()->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'country' => $faker->country
    ];
});
