<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,
        'start' => $faker->date,
        'end' => $faker->date,
        'color' => $faker->hexcolor
    ];
});
