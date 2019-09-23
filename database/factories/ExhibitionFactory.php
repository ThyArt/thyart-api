<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Exhibition::class, function (Faker $faker) {
	$unixTimestamp = '1461067200';
	$unixTimestampPast = '161067200';

    return [
        'name' => $faker->name ,
        'begin' => $faker->date('Y-m-d', $unixTimestampPast),
        'end' => $faker->date('Y-m-d', $unixTimestamp),

    ];
});
