<?php

use Faker\Generator as Faker;

$charge_list = [
    [
        'charge' => 'Assault On Law Enforcement Officer - 2nd Degree',
        'citation' => '565.082',
        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'felony',
        'sentence' => 'Min',

    ],
    [
        'charge' => 'Trafficking In Drugs In The Second Degree',
        'citation' => '195.223',
        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'felony',
        'sentence' => 'Min',

    ],
    [
        'charge' => 'Resisting/Interfering with an Arrest, Detention, or Stop',
        'citation' => '575.150',
        'conviction_class_type' => 'A',
        'conviction_charge_type' => 'misdemeanor',
        'sentence' => 'Min',

    ],
    [
        'charge' => 'Exceeded Posted Speed Limit (Exceeded By 11-15 Mph)',
        'citation' => '304.010',
        'conviction_class_type' => 'C',
        'conviction_charge_type' => 'Misdemeanor',
        'sentence' => 'Fine ($51.50) & Costs',
    ],
    [
        'charge' => 'Assault On Law Enforcement Officer - 2nd Degree',
        'citation' => '565.082',
        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'Felony',
        'sentence' => '7Years',
    ],
    [
        'charge' => 'Trafficking In Drugs In The Second Degree',
        'citation' => '195.223',
        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'Felony',
        'sentence' => '5Years',
    ],

];

$factory->define(\App\Charge::class, function (Faker $faker) use ($charge_list){
    $data = [
        'conviction_id' => \App\Conviction::inRandomOrder()->first()->id,
        'convicted' => 0,
        'eligible' => 0,
        'please_expunge' => 0,
        'to_print' => NULL,
        'notes' => NULL,
        'created_by' => '0',
        'modified_by' => '0',
        'purged_by' => '0',
        'created_at' => '2019-04-23',
        'updated_at' => '2019-04-23',
    ];
    return array_merge($data, $charge_list[array_rand($charge_list)]);
});
