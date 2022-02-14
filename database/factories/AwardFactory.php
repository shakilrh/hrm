<?php

use App\Employee;
use App\AwardType;
use Faker\Generator as Faker;

$factory->define(App\Award::class, function (Faker $faker) {
    return [
        'award_type_id' => function () {
            return AwardType::all()->random();
        },
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'gift_item' => $faker->word,
        'cash_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100.00, $max =1000.00),
        'date' => $faker->date
    ];
});
