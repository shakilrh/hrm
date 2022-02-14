<?php

use Faker\Generator as Faker;

$factory->define(App\AwardType::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => str_slug($name)
    ];
});
