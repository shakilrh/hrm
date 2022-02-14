<?php

use App\User;
use App\Branch;
use App\Department;
use App\Designation;
use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::role('employee')->get()->random();
        },
        'branch_id' => function () {
            return Branch::all()->random();
        },
        'department_id' => function () {
            return Department::all()->random();
        },
        'designation_id' => function () {
            return Designation::all()->random();
        },
        'employee_code' => 'E-'.$faker->unique()->randomNumber(),
        'phone' => $faker->phoneNumber,
        'alt_phone' => $faker->phoneNumber,
        'father_name' => $faker->name,
        'mother_name' => $faker->name,
        'gender' => \App\Enums\EmployeeGender::getRandomValue(),
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'present_address' => $faker->address,
        'permanent_address' => $faker->address,
        'date_of_join' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'basic_salary' => $faker->numberBetween($min = 1000, $max = 9000)
    ];
});
