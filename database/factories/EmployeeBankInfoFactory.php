<?php

use App\Employee;
use Faker\Generator as Faker;

$factory->define(App\EmployeeBankInfo::class, function (Faker $faker) {
    return [
        'employee_id' => function(){
            return Employee::all()->random();
        },
        'holder_name' => $faker->name,
        'bank_name' => $faker->word,
        'branch_name' => $faker->word,
        'account_number' => $faker->bankAccountNumber,
        'ifsc_code' => $faker->word,
        'pan_number' => $faker->word,
    ];
});
