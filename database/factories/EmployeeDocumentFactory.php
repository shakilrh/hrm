<?php

use App\Employee;
use Faker\Generator as Faker;

$factory->define(App\EmployeeDocument::class, function (Faker $faker) {
    $fileName = str_slug($faker->word);
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'name' => $fileName,
        'file' => $fileName.'.'.$faker->fileExtension
    ];
});
