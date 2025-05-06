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
        $residents = Resident::with('household')->paginate(10);
        return view('residents', compact('residents', 'households'));
    }

    public function store(Request $request)
    {
        try {
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
                    'household' => [
                        'id' => $resident->household->id,
                    ]
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create resident: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Resident $resident)
    {
        try {
            // Eager load household with its members
            $resident->load(['household.members' => function($query) {
                $query->orderBy('relationship', 'asc');
            }]);
        
            return response()->json([
                'full_name' => $resident->full_name,
                'gender' => $resident->gender,
                'birthdate' => $resident->birthdate,
                'contact' => $resident->contact,
                'income_source' => $resident->income_source,
                'household_head_name' => $resident->household_head_name, // Add this line
                'household' => $resident->household ? [
                    'id' => $resident->household->id,
                    'head_name' => $resident->household->head_name,
                    'purok' => $resident->household->purok,
                    'barangay' => $resident->household->barangay,
                    'city' => $resident->household->city,
                    'members' => $resident->household->members->map(function($member) {
                        return [
                            'full_name' => $member->full_name,
                            'relationship' => $member->relationship,
                            'birthdate' => $member->birthdate, // Send birthdate instead of age
                        ];
                    })
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch resident: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            // Add other validation rules
        ]);
    
        $resident = Resident::findOrFail($id);
        $resident->update($validated);
    
        return response()->json([
            'success' => true,
            'resident' => $resident
        ]);
    }
    
    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
    
        return response()->json(['success' => true]);
    }
}