<?php

namespace App\Http\Controllers;

use App\Charge;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function charge(Request $request, Charge $charge)
    {
        return $charge->load('histories');
    }
}
