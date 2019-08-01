<?php

use App\Client;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();

        $client = \App\Client::create([
            'id' => '2',
            'name' => 'Teresa Lee Kuvalis',
            'phone' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'sex' => 'Male',
            'race' => 'BlackorAfricanAmerican',
            'dob' => '1970-11-20',
            'address_line_1' => $faker->address,
            'address_line_2' => NULL,
            'city' => $faker->city,
            'state' => $faker->state,
            'zip_code' => $faker->postcode,
            'license_number' => 'L999999999',
            'license_issuing_state' => 'Missouri',
            'license_expiration_date' => '2025-04-23',
            'filing_court' => 'Jackson',
            'judicial_circuit_number' => 'NULL',
            'judge_name' => $faker->name,
            'division_name' => '4',
            'petitioner_name' => $faker->name,
            'division_number' => '4',
            'city_name_here' => NULL,
            'county_name' => NULL,
            'arresting_county' => 'JacksonCounty',
            'prosecuting_county' => 'Jackson',
            'arresting_municipality' => 'City of Kansas City (KCPD)',
            'other_agencies_name' => 'NULL',
            'created_by' => '0',
            'modified_by' => '1',
            'purged_by' => '0',
            'created_at' => '2019-04-22',
            'updated_at' => '2019-04-27',
            'previous_expungements' => NULL,
            'notes' => 'Check on parole release date.  If 2011 (per client), ready for expungement.  If 2013 (per records), wait 1 year on felony traficking. Assault on LEO not eligible',

        ]);

        dump('creating convictions for '.$client->name);
        $convictions = [
            [
                'id' => '2',
                'client_id' => '2',
                'name' => 'OriginalArrest/ChargesforTrafficking',
                'arrest_date' => '10/22/2003',
                'case_number' => '16CR9996477',
                'agency' => 'County',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => '2003/10/31',
                'release_date' => NULL,
                'notes' => 'Bound over Jury-Indictment 10/31/2003              Casefile Tranf GrandJury Indmt
Arrest may be tied to this original case. After transfer, this case was disposed of by plea in another docket (same docket number with an added dash1 (-1) So no charges to report',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
                'approximate_date_of_charge' => NULL,
            ],
            [
                'id' => '3',
                'client_id' => '2',
                'name' => 'TraffickingDrugs2ndDegree',
                'arrest_date' => '11/03/2003',
                'case_number' => '16CR039997-01',
                'agency' => 'County',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => NULL,
                'release_date' => '2013-05-02',
                'notes' => 'Release date says "OCN 05/02/2013; assume this is a release date that is about seven years after sentencing.  Says released from parole in 2011. Advised that Assault on LEO is not expungable per statute',

                'created_by' => '0',
                'modified_by' => '1',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-27',
                'approximate_date_of_charge' => NULL,
            ],
            [
                'id' => '4',
                'client_id' => '2',
                'name' => 'TraffickingDrugs/Attempt-2ndDegree',
                'arrest_date' => NULL,
                'case_number' => '16CR030999-01',
                'agency' => 'Circuit',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => 'Released',
                'release_date' => '2011-08-16',
                'notes' => 'Incarceration Record for the previous crime, perhaps. Refers to "Missouri Department of Corrections."  A note here. If we are seeing these type of cases where someone has three iterations of the same case, we need to be sure we are not assuming people have a complex case. Note from Ellen, Assault, Law Enforcement Officer not expungable.',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-23',
                'approximate_date_of_charge' => NULL,
            ],
            [
                'id' => '5',
                'client_id' => '2',
                'name' => 'Exceeded Speed Limit 11-15 miles per hour',
                'arrest_date' => '03/18/2004',
                'case_number' => '02199940',
                'agency' => 'Municipal',
                'court_name' => NULL,
                'court_city_county' => 'Independence',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => 'Record of Traffic Disp Issued',
                'release_date' => '2004-11-15',
                'notes' => 'Arresting Agency was Mo Highway Patrol General Headquarters',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',

            ],
            [
                'id' => '6',
                'client_id' => '2',
                'name' => 'Driving with out a license plate',
                'arrest_date' => NULL,
                'case_number' => NULL,
                'agency' => 'Municipal',
                'court_name' => NULL,
                'court_city_county' => 'Kansas City',
                'judge' => 'Payable without court appearance',
                'record_name' => 'Teresa L .Kuvalis',
                'release_status' => NULL,
                'release_date' => '2018-03-17',
                'notes' => 'Appears a bench warrant was issued; picked up on bench warrant and paid the fine.  May not have appeared before the court. At one place, it identifieds the Court 2',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
                'approximate_date_of_charge' => NULL,
            ]
        ];
        collect($convictions)->each(function ($c) {
            \App\Conviction::create($c);
        });

        dump('creating charges for '.$client->name);
        $charges = [
            [
                'id' => '2',
                'conviction_id' => '3',
                'charge' => 'Assault On Law Enforcement Officer - 2nd Degree',
                'citation' => '565.082',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'felony',
                'sentence' => 'Min',
                'convicted' => '1',
                'eligible' => NULL,
                'please_expunge' => NULL,
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ],
            [
                'id' => '3',
                'conviction_id' => '3',
                'charge' => 'Trafficking In Drugs In The Second Degree',
                'citation' => '195.223',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'felony',
                'sentence' => 'Min',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ],
            [
                'id' => '4',
                'conviction_id' => '3',
                'charge' => 'Resisting/Interfering with an Arrest, Detention, or Stop',
                'citation' => '575.150',
                'conviction_class_type' => 'A',
                'conviction_charge_type' => 'misdemeanor',
                'sentence' => 'Min',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ],
            [
                'id' => '5',
                'conviction_id' => '5',
                'charge' => 'Exceeded Posted Speed Limit (Exceeded By 11-15 Mph)',
                'citation' => '304.010',
                'conviction_class_type' => 'C',
                'conviction_charge_type' => 'Misdemeanor',
                'sentence' => 'Fine ($51.50) & Costs',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
            ],
            [
                'id' => '6',
                'conviction_id' => '4',
                'charge' => 'Assault On Law Enforcement Officer - 2nd Degree',
                'citation' => '565.082',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'Felony',
                'sentence' => '7Years',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
            ],
            [
                'id' => '7',
                'conviction_id' => '4',
                'charge' => 'Trafficking In Drugs In The Second Degree',
                'citation' => '195.223',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'Felony',
                'sentence' => '5Years',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',

            ],
            [
                'id' => '8',
                'conviction_id' => '4',
                'charge' => 'Resisting/Interfering With Arrest, Detention Or Stop',
                'citation' => '575.150',
                'conviction_class_type' => 'A',
                'conviction_charge_type' => 'Misdemeanor',
                'sentence' => '1Year',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => NULL,
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
            ],

            [
                'id' => '9',
                'conviction_id' => '6',
                'charge' => 'STATE LIC PLATE REQUIRED',
                'citation' => '96022060',
                'conviction_class_type' => NULL,
                'conviction_charge_type' => NULL,
                'sentence' => '$72.50 in fees and fines',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '0',
                'to_print' => NULL,
                'notes' => 'Statute70-137',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
            ]
        ];
        \App\Charge::insert($charges);

        dump('creating 100 clients with convictions and charges ');
        $clients = factory(App\Client::class, 100)->create();

        $clients->each(function ($client) {
            factory(\App\Conviction::class, rand(1, 5))->create(['client_id' => $client->id])
                ->each(function ($conviction) {
                    $number_of_charges = rand(0, 4);
                    if ($number_of_charges > 0) {
                        factory(\App\Charge::class, $number_of_charges)->create(['conviction_id' => $conviction->id]);
                    }
                });
        });

    }
}
