<?php

use Faker\Generator as Faker;

$factory->define(\App\Applicant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'notes' => 'Created',
        'dob' => $faker->date('1999-12-31'),
        'email' => $faker->safeEmailDomain(),
        'phone' => $faker->phoneNumber(),
        'cms_matter_number' => substr(bin2hex(random_bytes(16)), 0, 16),
    ];
});
