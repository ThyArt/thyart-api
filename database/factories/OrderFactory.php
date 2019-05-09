<?php

use App\User;
use App\Artwork;
use App\Customer;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
    		'user_id' => User::all()->random()->id,
    		'customer_id' => Customer::all()->random()->id,
    		'artwork_id' => Artwork::all()->random()->id,
        	'date' => $faker->date // might need refactor
      ];
});
