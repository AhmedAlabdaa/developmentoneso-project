<?php

namespace App\Http\Controllers;

class MonthlyContractPageController extends Controller
{
    public function index()
    {
        $now = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('monthly_contracts.index', compact('now'));
    }
}
