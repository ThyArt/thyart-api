<?php

use App\User;
use App\Gallery;
use App\Artwork;
use App\Customer;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    $galleryId = Gallery::has('customers')->has('artworks')->get()->random()->id;

    return [
            'user_id' => User::all()->random()->id,
            'customer_id' => Customer::whereGalleryId($galleryId)->get()->random()->id,
            'artwork_id' => Artwork::whereGalleryId($galleryId)->get()->random()->id,
            'date' => Carbon::createFromFormat('Y-m-d', $faker->date)
      ];
});
