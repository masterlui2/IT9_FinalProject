<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Household;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::with('household')->get();
        $households = Household::all();
        return view('residents', compact('residents', 'households'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female',
            'birthdate' => 'required|date',
            'household_id' => 'required|exists:households,id',
            'relationship' => 'required|string',
            'income_source' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);
    
        $resident = Resident::create($validated);
        
        return response()->json([
            'id' => $resident->id,
            'full_name' => $resident->full_name,
            'gender' => $resident->gender,
            'birthdate' => $resident->birthdate, // Already formatted as Y-m-d from the database
            'household_id' => $resident->household_id,
            'relationship' => $resident->relationship,
            'income_source' => $resident->income_source,
            'contact' => $resident->contact,
        ], 201);
    }
    public function destroy($id)
{
    $resident = Resident::find($id);

    if (!$resident) {
        return response()->json(['success' => false, 'message' => 'Resident not found.'], 404);
    }

    $resident->delete();

    return response()->json(['success' => true]);
}
// In app/Http/Controllers/ResidentController.php
public function show($id)
{
    try {
        $resident = Resident::with('household.members')->findOrFail($id);
        return response()->json($resident);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Resident not found'], 404);
    }
}
}