<?php

use App\Employee;
use Faker\Generator as Faker;

$factory->define(App\SalaryAllowance::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'name' => $faker->word,
        'amount' => $faker->numberBetween($min = 100, $max = 1000)
    ];
});
