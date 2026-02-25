<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;   

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $now   = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('services.index', compact('services','now'));
    }

    public function add()
    {
        $now   = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('services.add', compact('now'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name'         => 'required|string|max:255',
            'service_name_arabic'  => 'required|string|max:255',
            'govt_fee'             => 'required|string|max:255',
            'center_fee'           => 'required|string|max:255',
            'grand_total'          => 'required|string|max:255',
        ]);

        Service::create($data);
        return redirect()->route('services.index');
    }

    public function edit(Service $service)
    {
        $now   = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('services.edit', compact('service','now'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'service_name'         => 'required|string|max:255',
            'service_name_arabic'  => 'required|string|max:255',
            'govt_fee'             => 'required|string|max:255',
            'center_fee'           => 'required|string|max:255',
            'grand_total'          => 'required|string|max:255',
        ]);

        $service->update($data);
        return redirect()->route('services.index');
    }

    public function delete(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index');
    }
}
