<?php

use Faker\Generator as Faker;

$factory->define(App\Newsletter::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
        'description' => $faker->text,
    ];
});