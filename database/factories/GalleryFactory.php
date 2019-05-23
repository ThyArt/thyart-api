<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'name' => $faker->userName ,
        'address' => $faker->address ,
        'phone' => $faker->phoneNumber
    ];
});
