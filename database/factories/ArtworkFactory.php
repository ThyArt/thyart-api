<?php

use App\User;
use Faker\Generator as Faker;
use App\Artwork;

$factory->define(App\Artwork::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'name' => $faker->name,
        'price' => $faker->numberBetween(1, 1000000),
        'ref' => $faker->randomAscii,
        'state'=> Artwork::STATE_IN_STOCK,
    ];
});
