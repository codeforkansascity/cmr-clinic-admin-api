<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ApiTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:api-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display user info for API client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accessToken = env('TEST_API_TOKEN');
        $url = env('APP_URL');

        $client = new Client([                                     // GuzzleHttp\Client;
            'base_uri' => "$url/api/",
            'verify' => false,                                  // only for http:  remove for https:
        ]);

        $response = $client->request('GET', 'user', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]
        );
        echo $response->getBody();
    }
}
