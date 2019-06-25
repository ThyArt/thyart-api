<?php

use Faker\Generator as Faker;
use App\Artwork;
use App\Gallery;

$factory->define(App\Artwork::class, function (Faker $faker) {
    return [
        'gallery_id' => Gallery::all()->random()->id,
        'name' => $faker->name,
        'price' => $faker->numberBetween(1, 1000000),
        'ref' => $faker->randomAscii,
        'state'=> Artwork::STATE_IN_STOCK,
    ];
});
