<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'name' => $faker->userName ,
        'address' => $faker->address ,
        'phone' => $faker->phoneNumber
    ];
});
