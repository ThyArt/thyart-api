<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
    		'user_id' => User::all()->random()->id,
        	'price' => $faker->firstname // might need refactor
      ];
});
