<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Permit;
use Illuminate\Validation\ValidationException;

class PermitController extends Controller
{
    public function __call($method, $parameters)
    {
        if (str_starts_with($method, 'store')) {
            $permitType = strtolower(substr($method, 5));
            $request = request();

            try {
                return $this->handleStore($permitType, $request);
            } catch (ValidationException $e) {
                Log::error("Validation failed for {$permitType} permit: " . json_encode($e->errors()));
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                Log::error("Permit creation failed: {$e->getMessage()}");
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => [$e->getMessage()]
                ], 500);
            }
        }

        throw new \BadMethodCallException("Method {$method} does not exist");
    }

    protected function handleStore($permitType, Request $request)
    {
        $validTypes = ['residency', 'clearance', 'business', 'id'];

        if (!in_array($permitType, $validTypes)) {
            throw new \InvalidArgumentException("Invalid permit type: {$permitType}");
        }

        $validationRules = $this->getValidationRules($permitType);
        $validatedData = $request->validate($validationRules);

        $permitData = [
            'type' => $permitType,
            'full_name' => $validatedData['full_name'],
            'data' => json_encode($validatedData),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ];

        // 🔥 No user_id included
        $id = DatabaseHelper::quickInsert('permits', $permitData);

        return response()->json([
            'success' => true,
            'message' => ucfirst($permitType) . " permit created successfully!",
        ]);
    }

    protected function getValidationRules($permitType)
    {
        $baseRules = [
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:500',
            'contact_number' => 'required|string|max:20',
        ];

        $specificRules = [
            'residency' => [
                'years_residency' => 'required|integer|min:1',
                'purpose' => 'required|string|max:500'
            ],
            'clearance' => [
                'purpose' => 'required|string|max:500',
                'civil_status' => 'required|string',
                'gender' => 'required|string'
            ],
            'business' => [
                'business_name' => 'required|string|max:255',
                'business_type' => 'required|string|max:255',
                'business_address' => 'required|string|max:500'
            ],
            'id' => [
                'photo' => 'sometimes|file|image|max:2048',
                'citizenship' => 'required|string|max:255',
                'gender' => 'required|string',
                'civil_status' => 'required|string'
            ]
        ];

        return array_merge($baseRules, $specificRules[$permitType] ?? []);
    }

    // 🔄 Get all permit requests — now returns ALL, no filtering by user
    public function getMyRequests(Request $request)
    {
        try {
            $permits = Permit::orderBy('created_at', 'desc')
                ->get()
                ->map(function ($permit) {
                    return [
                        'id' => $permit->id,
                        'type' => $permit->type,
                        'full_name' => $permit->full_name,
                        'status' => $permit->status,
                        'created_at' => $permit->created_at,
                    ];
                });

            return response()->json($permits);
        } catch (\Exception $e) {
            Log::error("Failed to fetch permits: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load requests'
            ], 500);
        }
    }
    public function show($id)
    {
        $permit = Permit::find($id);
        
        if (!$permit) {
            return response()->json([
                'message' => 'Permit not found'
            ], 404);
        }
    
        return response()->json($permit);
    }

public function approve(Request $request, $id)
{
    $permit = Permit::findOrFail($id);
    
    $permit->update([
        'status' => 'approved',
        'notes' => $request->notes,
        'approved_at' => now()
    ]);
    
    return response()->json([
        'message' => 'Permit approved successfully',
        'permit' => $permit
    ]);
}

public function destroy($id)
{
    $permit = Permit::findOrFail($id);
    $permit->delete();
    
    return response()->json([
        'message' => 'Permit deleted successfully'
    ]);
}
    public function getClearanceRequests()
    {
        $permits = Permit::where('type', 'clearance')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('permits.admin.clearance', ['permits' => $permits]);
    }
}
