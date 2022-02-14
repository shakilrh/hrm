<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'user_id' => function(){
            return User::all()->random();
        },
        'name' => $name,
        'slug' => str_slug($name),
        'status' => $faker->boolean
    ];
});
