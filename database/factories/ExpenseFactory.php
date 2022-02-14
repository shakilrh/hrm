<?php

use App\Employee;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Expense::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'item_name' => $faker->sentence,
        'purchase_from' => $faker->name,
        'purchase_date' => Carbon::now()->toDateString(),
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100.00, $max = 1000.00),
        'bill_copy' => 'bill_copy-'.$faker->fileExtension
    ];
});
