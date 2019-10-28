<?php

use App\Conviction;
use App\ConvictionService;
use App\Service;
use App\ServiceType;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Faker\Generator as Faker;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        /// cleanup
        DB::unprepared('set FOREIGN_KEY_CHECKS=0');
        ConvictionService::truncate();
        Service::truncate();
        ServiceType::truncate();
        DB::unprepared('set FOREIGN_KEY_CHECKS=1');

        $start = microtime(1);
        $service_types = ['County/City', 'Court', 'Arresting Agency'];

        $index = 1;
        $service_types = collect($service_types)->map(function ($type) use (&$index) {
            return [
                'id' => $index++,
                'name' => $type,
                'created_at' => now(),
            ];
        });
        ServiceType::insert($service_types->toArray());
        dump("Inserted ". count($service_types)." Services Types in ". round(microtime(1) - $start, 2). ' seconds');


        $start = microtime(1);

        $services = [];
        $index = 1;
        foreach ($service_types as $type) {
            $services = array_merge( $services, factory(Service::class, 100)->make(['service_type_id' => $type['id']])->toArray() );
        }
        foreach ($services as &$service) {
            $service['id'] = $index++;
        }

        Service::insert($services);
        dump("Inserted ". count($services)." Services in ". round(microtime(1) - $start, 2). ' seconds');


        $start = microtime(1);
        $convictions = Conviction::get()->shuffle();
        $count = count($services);
        $conviction_services = [];
        foreach ($convictions as $conviction) {
            foreach (range(0, rand(1,3)) as $i) {
                $conviction_services []= [
                    'conviction_id' => $conviction['id'],
                    'service_id' => $services[rand(0, $count-1)]['id'],
                    'name' => $faker->name,
                ];
            }
        }

        ConvictionService::insert($conviction_services);
        dump("Inserted ". count($conviction_services)." Conviction Services in ". round(microtime(1) - $start, 2). ' seconds');



    }
}
