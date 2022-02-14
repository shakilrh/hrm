<?php

use App\Employee;
use App\Enums\PayslipStatus;
use Faker\Generator as Faker;

$factory->define(App\Payslip::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'year' => $faker->year($max = 'now'),
        'month' => $faker->numberBetween($min = 1, $max = 12),
        'instant_deduction' => $faker->numberBetween($min = 100, $max = 1000),
        'deduction_reason' => $faker->sentence,
        'status' => PayslipStatus::getRandomValue()
    ];
});
