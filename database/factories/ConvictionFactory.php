<?php

use Faker\Generator as Faker;

$factory->define(\App\Conviction::class, function (Faker $faker) {
    $applicant = \App\Applicant::inRandomOrder()->first();
    /// random day between - 3 years and - 15 years
//    $release = today()->subDays(rand( (365*3), (365*15) ));

    return [
        'applicant_id' => $applicant->id,
        'name' => 'Driving with out a license plate',
        'arrest_date' => NULL,
        'case_number' => NULL,
        'agency' => 'Municipal',
        'court_name' => NULL,
        'court_city_county' => 'Kansas City',
        'judge' => 'Payable without court appearance',
        'record_name' => $applicant->name,
        'release_status' => NULL,
//        'release_date' => $release,
        'notes' => 'Appears a bench warrant was issued; picked up on bench warrant and paid the fine.  May not have appeared before the court. At one place, it identifieds the Court 2',
        'created_by' => '0',
        'modified_by' => '0',
        'purged_by' => '0',
        'created_at' => '2019-04-23',
        'updated_at' => '2019-04-23',
        'date_of_charge' => NULL,
    ];
});
