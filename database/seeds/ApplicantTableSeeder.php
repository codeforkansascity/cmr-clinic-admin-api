<?php

use App\Applicant;
use App\Charge;
use App\Conviction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ApplicantTableSeeder extends Seeder
{
    protected $charges = [];
    protected $convictions = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $applicant = \App\Applicant::create([
            'id' => '2',
            'assignment_id' => '3',
            'name' => 'Jane Eyre Doe',
            'phone' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'sex' => 'Female',
            'race' => 'Asian',
            'dob' => '1981-12-25',
            'address_line_1' => '569 Maple Street',
            'address_line_2' => null,
            'city' => 'Peculiar',
            'state' => 'Missouri ',
            'zip_code' => '55432',
            'license_number' => 'L999999999',
            'license_issuing_state' => 'Missouri',
            'license_expiration_date' => '2025-04-23',
//            'filing_court' => 'Jackson',
//            'judicial_circuit_number' => 'NULL',
//            'judge_name' => $faker->name,
//            'division_name' => '4',
//            'petitioner_name' => $faker->name,
//            'division_number' => '4',
//            'city_name_here' => NULL,
//            'county_name' => NULL,
//            'arresting_county' => 'JacksonCounty',
//            'prosecuting_county' => 'Jackson',
//            'arresting_municipality' => 'City of Kansas City (KCPD)',
//            'other_agencies_name' => 'NULL',
            'created_by' => '0',
            'modified_by' => '1',
            'purged_by' => '0',
            'created_at' => '2019-04-22',
            'updated_at' => '2019-04-27',
            'previous_expungements' => null,
            'notes' => 'Check on parole release date.  If 2011 (per applicant), ready for expungement.  If 2013 (per records), wait 1 year on felony traficking. Assault on LEO not eligible',
            'case_heading' => '16TH CIRCUIT JUDICIAL CIRCUIT, JACKSON COUNTY, MISSOURI',
            'case_no' => '2020',
            'counsel_or_pro_se_statment' => 'by and through counsel Pablo Picasso of Bangles and Jangles LC',
            'signature_block_heading' => 'Bangles and Jangles LC',
            'signature_block_name' => 'Pablo Picasso',
            'signature_block_bar_number_or_pro_se' => 'Missouri Bar #54299',
            'signature_block_address' => '4110 Madison Ave, Suite 200',
            'signature_block_city_state_zip' => 'Kansas City, MO 64111',
            'signature_block_phone' => '(816) 555-1212',
            'signature_block_email' => 'pablo@bajlc.com',
        ]);

        dump('creating convictions for '.$applicant->name);
        $convictions = [
            [
                'id' => '2',
                'applicant_id' => '2',
                'name' => '',
                'arrest_date' => '09/15/2004',
                'case_number' => '16CR9996477',
                'agency' => 'KCMO Police',
                'court_name' => 'Circuit Court of Jackson County, Missouri',
                'court_city_county' => 'Jackson',
                'judge' => 'Smith',
                'record_name' => 'Jane Eyre Doe',
                'release_status' => '',
                 'release_date' => '2008-08-12',
                'notes' => '',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
                'date_of_charge' => '2004-11-03',
            ],
            [
                'id' => '3',
                'applicant_id' => '2',
                'name' => '',
                'arrest_date' => '2006-09-23',
                'case_number' => '16CR039997-01',
                'agency' => 'County',
                'court_name' => 'Circuit Court of Jackson County, Missouri',
                'court_city_county' => 'Jackson',
                'judge' => 'Smith',
                'record_name' => 'Jane Eyre Doe',
                'release_status' => null,
                // 'release_date' => '2013-05-02',
                'notes' => '',

                'created_by' => '0',
                'modified_by' => '1',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-27',
                'date_of_charge' => null,
            ]
        ];
        collect($convictions)->each(function ($c) {
            \App\Conviction::create($c);
        });

        dump('creating charges for '.$applicant->name);
        $charges = [
            [
                'id' => '2',
                'conviction_id' => '2',
                'statute_id' => 1,
                'imported_citation' => '195.211',
                //'imported_statute' => 'Distribution, Delivery, Manufacture or Production of a Controlled Substance',
                'conviction_class_type' => 'D',
                'conviction_charge_type' => 'Felony',
                'sentence' => 'Min',
                'convicted' => '1',
                'eligible' => null,
                'please_expunge' => 1,
                'to_print' => null,
                'notes' => 'Says this is the charge that has been causing them problems when applying for a job.',

                'petition_number' => 1,
                'group_number' => 1,
                'group_sequence' => 1,


                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ],
            [
                'id' => '3',
                'conviction_id' => '2',
                'statute_id' => 2,
                'imported_citation' => '195.223',
                //'imported_statute' => 'Posession of Drug Paraphernalia',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'Misdemeanor',
                'sentence' => '',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '1',
                'to_print' => null,
                'notes' => null,

                'petition_number' => 1,
                'group_number' => 1,
                'group_sequence' => 2,


                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ],
            [
                'id' => '4',
                'conviction_id' => '3',
                'statute_id' => 3,
                'imported_citation' => '2006-034',
                //'imported_statute' => 'Failing to Drive Within A Single Lane 304.015 R.S. Mo. deemed an Infraction',
                'conviction_class_type' => 'B',
                'conviction_charge_type' => 'Misdemeanor',
                'sentence' => 'Min',
                'convicted' => '1',
                'eligible' => '0',
                'please_expunge' => '1',
                'to_print' => null,
                'notes' => null,

                'petition_number' => 1,
                'group_number' => 2,
                'group_sequence' => 1,


                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
            ]
        ];
        \App\Charge::insert($charges);

        $start = microtime(1);
        dump('creating 100 applicants with convictions and charges ');
        $index = Applicant::max('id') + 1;
        $applicants = factory(App\Applicant::class, 3)->make()
            ->map(function ($applicant) use (&$index) {
                $applicant['id'] = $index++;

                return $applicant;
            });

        Applicant::insert($applicants->toArray());
        dump('Inserted Applicants in '.round(microtime(1) - $start, 2).' seconds');

        $start = microtime(1);
        $index = (Conviction::max('id') ?? 1) + 1;

        $charges = collect($applicants)->each(function ($applicant) use (&$index) {
            $convictions = factory(\App\Conviction::class, rand(1, 5))
                ->make(['applicant_id' => $applicant['id']])
                ->map(function ($conviction) use (&$index) {
                    $conviction['id'] = $index++;

                    return $conviction;
                });

            $this->convictions = array_merge($convictions->toArray(), $this->convictions);
            $convictions->each(function ($conviction) {
                $number_of_charges = rand(0, 4);
                if ($number_of_charges > 0) {
                    $charges = factory(\App\Charge::class, $number_of_charges)->make(['conviction_id' => $conviction['id']]);
                    $this->charges = array_merge($charges->toArray(), $this->charges);
                }
            });
        });

        dump('Build arrays in '.round(microtime(1) - $start, 2).' seconds');

        $start = microtime(1);
        Conviction::insert($this->convictions);
        dump('Inserted '.count($this->convictions).' convictions');
        dump('Inserted Convictions in '.round(microtime(1) - $start, 2).' seconds');

        $start = microtime(1);

        Charge::insert($this->charges);
        dump('Inserted '.count($this->charges).' charges');
        dump('Inserted Charges in '.round(microtime(1) - $start, 2).' seconds');
    }
}
