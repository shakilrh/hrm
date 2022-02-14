<?php

use App\Department;
use Faker\Generator as Faker;

$factory->define(App\Designation::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'department_id' => function () {
            return Department::all()->random();
        },
        'name' => $name,
        'slug' => str_slug($name),
        'status' => $faker->boolean
    ];
});
