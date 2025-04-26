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
            'contact' => 'nullable|string|max:20',
            'household_head_name' => 'required|string|max:255',
        ]);
    
        $resident = Resident::create($validated);
        
        return response()->json([
            'success' => true,
            'resident' => [
                'id' => $resident->id,
                'full_name' => $resident->full_name,
                'gender' => $resident->gender,
                'birthdate' => $resident->birthdate?->format('Y-m-d'),
                'household_id' => $resident->household_id,
                'income_source' => $resident->income_source,
                'contact' => $resident->contact,
                'household' => [ // Include if you need household details
                    'id' => $resident->household->id,
                    // ... other household fields
                ]
            ]
        ], 201);
    }
    public function show($id)
    {
        try {
            $resident = Resident::with(['household', 'household.members' => function($query) {
                $query->select('id', 'full_name', 'relationship', 'household_id');
            }])->findOrFail($id);
    
            return response()->json([
                'success' => true,
                'data' => [
                    'full_name' => $resident->full_name,
                    'gender' => $resident->gender,
                    'birthdate' => $resident->birthdate,
                    'contact' => $resident->contact,
                    'income_source' => $resident->income_source,
                    'household' => $resident->household ? [
                        'id' => $resident->household->id,
                        'purok' => $resident->household->purok,
                        'barangay' => $resident->household->barangay,
                        'city' => $resident->household->city,
                        'head_name' => $resident->household->head_name,
                        'members' => $resident->household->members
                    ] : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resident not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $resident = Resident::findOrFail($id);
            $resident->delete();

            return response()->json([
                'success' => true,
                'message' => 'Resident deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete resident'
            ], 500);
        }
    }
}