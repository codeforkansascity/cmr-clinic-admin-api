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

        $user = \App\Client::create([
            'id' => '2',
            'full_name' => 'Teresa Lee Kuvalis',
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
            'license_expiration_date' => '11/03/2025',
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
            'status' => 'Check on parole release date.  If 2011 (per client), ready for expungement.  If 2013 (per records), wait 1 year on felony traficking. Assault on LEO not eligible',

        ]);
    }
}
