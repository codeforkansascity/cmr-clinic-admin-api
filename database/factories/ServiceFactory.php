<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Service;
use App\ServiceType;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'service_type_id' => ServiceType::inRandomOrder()->first()->id,
        'address' => $faker->address,
        'phone' => substr($faker->phoneNumber, 0, 12),
        'email' => $faker->email,
        'note' => $faker->text(150),
    ];
});
