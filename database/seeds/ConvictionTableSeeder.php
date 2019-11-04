<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ConvictionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $conviction = \App\Conviction::create([
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
//            'release_date' => NULL,
            'notes' => 'Bound over Jury-Indictment
10/31/2003              Casefile Tranf GrandJury Indmt
Arrest may be tied to this original case. After transfer, this case was disposed of by plea in another docket (same docket number with an added dash1 (-1) So no charges to report',
            'created_by' => '0',
            'modified_by' => '0',
            'purged_by' => '0',
            'created_at' => '2019-04-22',
            'updated_at' => '2019-04-22',
            'date_of_charge' => NULL,
        ]);
        $conviction = \App\Conviction::create([
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
        ]);

        $conviction = \App\Conviction::create([
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
        ]);

        $conviction = \App\Conviction::create([
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

        ]);

        $conviction = \App\Conviction::create([
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
        ]);

    }
}
