<?php

use App\Employee;
use App\LeaveType;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\LeaveApplication::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'leave_type_id' => function () {
            return LeaveType::all()->random();
        },
        'leave_form' => Carbon::now()->toDateString(),
        'leave_to' => Carbon::tomorrow()->toDateString(),
        'leave_reason' => $faker->sentence,
    ];
});
