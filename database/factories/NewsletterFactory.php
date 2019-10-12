<?php

use Faker\Generator as Faker;
use App\Customer;

$factory->define(App\Newsletter::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
        'description' => $faker->name,
    ];
});