<?php

use Faker\Generator as Faker;
use App\Artist;

$factory->define(Artist::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(),
        'genre' => $faker->randomElement(['rock', 'pop', 'country', 'folk', null]),
        'description' => $faker->text,
    ];
});
