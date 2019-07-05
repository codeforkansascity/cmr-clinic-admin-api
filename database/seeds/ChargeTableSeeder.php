<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ChargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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

        ]);

        $charge = \App\Charge::create([
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
        ]);

        $charge = \App\Charge::create([
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
        ]);


    }
}
