<?php

use App\Employee;
use Faker\Generator as Faker;

$factory->define(App\SalaryIncrement::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'amount' => $faker->numberBetween($min = 100, $max = 1000),
        'remark' => $faker->sentence
    ];
});
