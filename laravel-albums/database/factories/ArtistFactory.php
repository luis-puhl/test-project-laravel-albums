<?php

use Faker\Generator as Faker;
use App\Models\Artist;

$factory->define(Artist::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => 'http://via.placeholder.com/150x150',
        'genre' => $faker->randomElement(['rock', 'pop', 'country', 'folk', null]),
        'description' => $faker->paragraph,
    ];
});
