<?php

namespace App\Http\Controllers;

use App\Charge;
use App\Client;
use App\Conviction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function charge(Request $request, Charge $charge)
    {
        return $charge->load(['histories' => function ($q) {
            $q->with(['user']);
        }]);
    }

    public function case(Conviction $convictions)
    {
        /// return client, cases, charges and histories with everything
        return $convictions->load([
            'histories' => function ($q) {
                $q->with(['user']);
            },
            'charge' => function ($q) {
                $q->with(['histories' => function ($q) {
                    $q->with(['user']);
                }]);
            }
        ]);
    }

    public function client(Client $client)
    {
        /// return client, cases, charges and histories with everything
        DB::enableQueryLog();
        $history = $client->load([
            'conviction' => function ($q) {
                $q->with([
                    'histories' => function ($q) {
                        $q->with(['user']);
                    },
                    'charge' => function ($q) {
                        $q->with(['histories' => function ($q) {
                            $q->with(['user']);
                        }]);
                    }
                ]);
            }
        ]);

        return [$history, DB::getQueryLog()];
    }
}
