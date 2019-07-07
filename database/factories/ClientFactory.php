<?php

use Faker\Generator as Faker;

$factory->define(\App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'status' => 'Created',
        'dob' => $faker->date('1999-12-31'),
        'email' => $faker->safeEmailDomain(),
        'phone' => $faker->phoneNumber(),
    ];
});
