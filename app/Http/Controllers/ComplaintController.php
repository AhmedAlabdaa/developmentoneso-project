<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Display a listing of the complaints
    public function index()
    {
        $complaints = Complaint::with('attachments')->get();
        return response()->json($complaints);
    }

    // Store a newly created complaint in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'request_from' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:Pending,Processing,Done,Not Done',
        ]);

        $complaint = Complaint::create($validated);
        return response()->json($complaint, 201);
    }

    // Display the specified complaint
    public function show($id)
    {
        $complaint = Complaint::with('attachments')->findOrFail($id);
        return response()->json($complaint);
    }

    // Update the specified complaint in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string',
            'role' => 'string',
            'request_from' => 'string',
            'description' => 'string',
            'status' => 'in:Pending,Processing,Done,Not Done',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update($validated);

        return response()->json($complaint);
    }

    // Remove the specified complaint from storage
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();
        
        return response()->json(null, 204);
    }
}
