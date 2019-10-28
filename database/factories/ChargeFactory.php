<?php

use App\Statute;
use Faker\Generator as Faker;

$charge_list = [
    [

        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'felony',
        'sentence' => 'Min',

    ],
    [

        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'felony',
        'sentence' => 'Min',

    ],
    [

        'conviction_class_type' => 'A',
        'conviction_charge_type' => 'misdemeanor',
        'sentence' => 'Min',

    ],
    [

        'conviction_class_type' => 'C',
        'conviction_charge_type' => 'Misdemeanor',
        'sentence' => 'Fine ($51.50) & Costs',
    ],
    [

        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'Felony',
        'sentence' => '7Years',
    ],
    [

        'conviction_class_type' => 'B',
        'conviction_charge_type' => 'Felony',
        'sentence' => '5Years',
    ],

];

$factory->define(\App\Charge::class, function (Faker $faker) use ($charge_list){
    $data = [
        'conviction_id' => \App\Conviction::inRandomOrder()->first()->id ?? 1,
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
        'statute_id' => Statute::inRandomOrder()->first()->id ?? 1
    ];
    return array_merge($data, $charge_list[array_rand($charge_list)]);
});
