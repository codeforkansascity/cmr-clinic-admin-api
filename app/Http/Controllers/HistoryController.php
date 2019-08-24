<?php

namespace App\Http\Controllers;

use App\Charge;
use Illuminate\Http\Request;
use function foo\func;

class HistoryController extends Controller
{
    public function charge(Request $request, Charge $charge)
    {
        return $charge->load(['histories' => function ($q) {
            $q->with(['user']);
        }]);
    }
}
