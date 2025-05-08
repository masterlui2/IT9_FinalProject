<?php

namespace App\Http\Controllers;

use App\Models\BarangayClearanceRequest;
use App\Models\ResidencyRequest;
use App\Models\BusinessPermitRequest;
use App\Models\BarangayIdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermitController extends Controller
{
    public function index()
    {
        return view('permits');
    }

    public function storeClearance(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'birthdate' => 'required|date',
            'age' => 'required|integer|min:1',
            'gender' => 'required|string|in:Male,Female,Other',
            'civil_status' => 'required|string|in:Single,Married,Widowed,Separated',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'date_requested' => 'required|date',
        ]);

        try {
            $clearance = BarangayClearanceRequest::create($validated);
            
            Log::info("Clearance request created", ['id' => $clearance->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Barangay clearance request submitted successfully!',
                'data' => $clearance
            ]);
        } catch (\Exception $e) {
            Log::error("Clearance request error: " . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getTrace()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request. Please try again.'
            ], 500);
        }
    }

    public function storeResidency(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'age' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'years_of_residency' => 'required|integer|min:0',
            'purpose' => 'required|string|max:255',
            'date_requested' => 'required|date',
        ]);

        try {
            $residency = ResidencyRequest::create($validated);
            
            Log::info("Residency request created", ['id' => $residency->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Residency certificate request submitted successfully!',
                'data' => $residency
            ]);
        } catch (\Exception $e) {
            Log::error("Residency request error: " . $e->getMessage(), [
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit residency request. Please try again.'
            ], 500);
        }
    }

    public function storeBusiness(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'tin' => 'nullable|string|max:50',
            'dti_registration_no' => 'nullable|string|max:50',
            'date_application' => 'required|date',
            'contact_number' => 'required|string|max:20',
        ]);

        try {
            $business = BusinessPermitRequest::create($validated);
            
            Log::info("Business permit request created", ['id' => $business->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Business permit request submitted successfully!',
                'data' => $business
            ]);
        } catch (\Exception $e) {
            Log::error("Business permit error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit business permit request.'
            ], 500);
        }
    }

    public function storeId(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'civil_status' => 'required|string|in:Single,Married,Widowed,Separated',
            'citizenship' => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'id_photo' => 'required|file|image|max:2048', // 2MB max
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('id_photo')) {
                $path = $request->file('id_photo')->store('id_photos', 'public');
                $validated['id_photo_path'] = $path;
            }

            $idRequest = BarangayIdRequest::create($validated);
            
            Log::info("Barangay ID request created", ['id' => $idRequest->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Barangay ID request submitted successfully!',
                'data' => $idRequest
            ]);
        } catch (\Exception $e) {
            Log::error("Barangay ID error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit Barangay ID request.'
            ], 500);
        }
    }

    public function getMyRequests()
    {
        try {
            $requests = collect()
                ->merge(
                    BarangayClearanceRequest::select('id', 'full_name', 'status', 'created_at')
                        ->latest()
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Barangay Clearance';
                            $item->date = $item->created_at->format('Y-m-d');
                            return $item;
                        })
                )
                ->merge(
                    ResidencyRequest::select('id', 'full_name', 'status', 'created_at')
                        ->latest()
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Certificate of Residency';
                            $item->date = $item->created_at->format('Y-m-d');
                            return $item;
                        })
                )
                ->merge(
                    BusinessPermitRequest::select('id', 'business_name as full_name', 'status', 'created_at')
                        ->latest()
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Business Permit';
                            $item->date = $item->created_at->format('Y-m-d');
                            return $item;
                        })
                )
                ->merge(
                    BarangayIdRequest::select('id', 'full_name', 'status', 'created_at')
                        ->latest()
                        ->get()
                        ->map(function ($item) {
                            $item->type = 'Barangay ID';
                            $item->date = $item->created_at->format('Y-m-d');
                            return $item;
                        })
                )
                ->sortByDesc('created_at')
                ->values();

            return response()->json($requests);
        } catch (\Exception $e) {
            Log::error("Error fetching requests: " . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function delete($id)
    {
        try {
            $models = [
                BarangayClearanceRequest::class,
                ResidencyRequest::class,
                BusinessPermitRequest::class,
                BarangayIdRequest::class,
            ];

            foreach ($models as $model) {
                if ($record = $model::find($id)) {
                    $record->delete();
                    Log::info("Request deleted", ['id' => $id, 'type' => $model]);
                    return response()->json(['success' => true]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error("Delete error: " . $e->getMessage(), ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting request'
            ], 500);
        }
    }
}