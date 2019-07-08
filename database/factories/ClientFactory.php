<?php

use Faker\Generator as Faker;

$factory->define(\App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'notes' => 'Created',
        'dob' => $faker->date('1999-12-31'),
        'email' => $faker->safeEmailDomain(),
        'phone' => $faker->phoneNumber(),
    ];
});
