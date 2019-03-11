<?php

use Faker\Generator as Faker;
use App\Artwork;

$factory->define(App\Artwork::class, function (Faker $faker) {

    return [
        'id' => $faker->numberBetween(1, 1000000),
        'name' => $faker->name,
        'price' => $faker->numberBetween(1, 1000000),
        'ref' => $faker->randomAscii,
        'state'=> Artwork::STATE_IN_STOCK,
    ];
});
