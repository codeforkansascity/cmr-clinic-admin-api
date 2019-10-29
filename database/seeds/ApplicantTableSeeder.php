<?php

use App\Charge;
use App\Applicant;
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
            'name' => 'Teresa Lee Kuvalis',
            'phone' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'sex' => 'Male',
            'race' => 'Black or African American',
            'dob' => '1970-11-20',
            'address_line_1' => $faker->address,
            'address_line_2' => NULL,
            'city' => $faker->city,
            'state' => 'Kansas',
            'zip_code' => $faker->postcode,
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
            'previous_expungements' => NULL,
            'notes' => 'Check on parole release date.  If 2011 (per applicant), ready for expungement.  If 2013 (per records), wait 1 year on felony traficking. Assault on LEO not eligible',

        ]);

        dump('creating convictions for '.$applicant->name);
        $convictions = [
            [
                'id' => '2',
                'applicant_id' => '2',
                'name' => 'OriginalArrest/ChargesforTrafficking',
                'arrest_date' => '10/22/2003',
                'case_number' => '16CR9996477',
                'agency' => 'County',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => '2003/10/31',
                // 'release_date' => NULL,
                'notes' => 'Bound over Jury-Indictment 10/31/2003              Casefile Tranf GrandJury Indmt
Arrest may be tied to this original case. After transfer, this case was disposed of by plea in another docket (same docket number with an added dash1 (-1) So no charges to report',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-22',
                'date_of_charge' => NULL,
            ],
            [
                'id' => '3',
                'applicant_id' => '2',
                'name' => 'TraffickingDrugs2ndDegree',
                'arrest_date' => '11/03/2003',
                'case_number' => '16CR039997-01',
                'agency' => 'County',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => NULL,
                // 'release_date' => '2013-05-02',
                'notes' => 'Release date says "OCN 05/02/2013; assume this is a release date that is about seven years after sentencing.  Says released from parole in 2011. Advised that Assault on LEO is not expungable per statute',

                'created_by' => '0',
                'modified_by' => '1',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-27',
                'date_of_charge' => NULL,
            ],
            [
                'id' => '4',
                'applicant_id' => '2',
                'name' => 'TraffickingDrugs/Attempt-2ndDegree',
                'arrest_date' => NULL,
                'case_number' => '16CR030999-01',
                'agency' => 'Circuit',
                'court_name' => NULL,
                'court_city_county' => 'Jackson',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => 'Released',
                // 'release_date' => '2011-08-16',
                'notes' => 'Incarceration Record for the previous crime, perhaps. Refers to "Missouri Department of Corrections."  A note here. If we are seeing these type of cases where someone has three iterations of the same case, we need to be sure we are not assuming people have a complex case. Note from Ellen, Assault, Law Enforcement Officer not expungable.',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-22',
                'updated_at' => '2019-04-23',
                'date_of_charge' => NULL,
            ],
            [
                'id' => '5',
                'applicant_id' => '2',
                'name' => 'Exceeded Speed Limit 11-15 miles per hour',
                'arrest_date' => '03/18/2004',
                'case_number' => '02199940',
                'agency' => 'Municipal',
                'court_name' => NULL,
                'court_city_county' => 'Independence',
                'judge' => $faker->name,
                'record_name' => 'Teresa Kuvalis',
                'release_status' => 'Record of Traffic Disp Issued',
                // 'release_date' => '2004-11-15',
                'notes' => 'Arresting Agency was Mo Highway Patrol General Headquarters',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',

            ],
            [
                'id' => '6',
                'applicant_id' => '2',
                'name' => 'Driving with out a license plate',
                'arrest_date' => NULL,
                'case_number' => NULL,
                'agency' => 'Municipal',
                'court_name' => NULL,
                'court_city_county' => 'Kansas City',
                'judge' => 'Payable without court appearance',
                'record_name' => 'Teresa L .Kuvalis',
                'release_status' => NULL,
                // 'release_date' => '2018-03-17',
                'notes' => 'Appears a bench warrant was issued; picked up on bench warrant and paid the fine.  May not have appeared before the court. At one place, it identifieds the Court 2',
                'created_by' => '0',
                'modified_by' => '0',
                'purged_by' => '0',
                'created_at' => '2019-04-23',
                'updated_at' => '2019-04-23',
                'date_of_charge' => NULL,
            ]
        ];
        collect($convictions)->each(function ($c) {
            \App\Conviction::create($c);
        });

        dump('creating charges for '.$applicant->name);
        $charges = [
            [
                'id' => '2',
                'conviction_id' => '3',
                'imported_citation' => '565.082',
                'imported_statute' => 'Assault On Law Enforcement Officer - 2nd Degree',
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
                'imported_citation' => '195.223',
                'imported_statute' => 'Trafficking In Drugs In The Second Degree',
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
                'imported_citation' => '575.150',
                'imported_statute' => 'Resisting/Interfering with an Arrest, Detention, or Stop',
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
                'imported_citation' => '304.010',
                'imported_statute' => 'Exceeded Posted Speed Limit (Exceeded By 11-15 Mph)',
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
                'imported_citation' => '565.082',
                'imported_statute' => 'Assault On Law Enforcement Officer - 2nd Degree',
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
                'imported_citation' => '195.223',
                'imported_statute' => 'Trafficking In Drugs In The Second Degree',
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
                'conviction_class_type' => 'A',
                'conviction_charge_type' => 'Misdemeanor',
                'imported_citation' => '195.223',
                'imported_statute' => 'Trafficking In Drugs In The Second Degree',
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
                'conviction_class_type' => NULL,
                'conviction_charge_type' => NULL,
                'sentence' => '$72.50 in fees and fines',
                'imported_citation' => '195.223',
                'imported_statute' => 'Trafficking In Drugs In The Second Degree',
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

        $start = microtime(1);
        dump('creating 100 applicants with convictions and charges ');
        $index = Applicant::max('id')+1;
        $applicants = factory(App\Applicant::class, 100)->make()
            ->map(function ($applicant) use(&$index) {
                $applicant['id'] = $index++;
                return $applicant;
            });

        Applicant::insert($applicants->toArray());
        dump("Inserted Applicants in ". round(microtime(1) - $start, 2). ' seconds');

        $start = microtime(1);
        $index = (Conviction::max('id') ?? 1)+1;

        $charges = collect($applicants)->each(function ($applicant) use (&$index){
            $convictions = factory(\App\Conviction::class, rand(1, 5))
                ->make(['applicant_id' => $applicant['id']])
                ->map(function ($conviction) use(&$index) {
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

        dump("Build arrays in ". round(microtime(1) - $start, 2). ' seconds');

        $start = microtime(1);
        Conviction::insert($this->convictions);
        dump('Inserted '. count($this->convictions). ' convictions');
        dump("Inserted Convictions in ". round(microtime(1) - $start, 2). ' seconds');

        $start = microtime(1);

        Charge::insert($this->charges);
        dump('Inserted '. count($this->charges). ' charges');
        dump("Inserted Charges in ". round(microtime(1) - $start, 2). ' seconds');


    }
}
