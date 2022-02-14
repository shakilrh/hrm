<?php

use App\Employee;
use App\Attendance;
use Faker\Generator as Faker;

$factory->define(App\AttendanceData::class, function (Faker $faker) {
    return [
        'attendance_id' => function () {
            return Attendance::all()->random();
        },
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'status' => $faker->numberBetween($min = 0, $max = 1),
        'remark' => $faker->sentence
    ];
});
