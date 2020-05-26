<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->randomNumber($nbDigits = 8),
        'description' => $faker->sentence(),
    ];
});
