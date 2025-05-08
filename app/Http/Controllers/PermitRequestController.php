<?php

namespace App\Http\Controllers;

use App\Models\BarangayClearanceRequest;
use App\Models\ResidencyRequest;
use App\Models\BusinessPermitRequest;
use App\Models\BarangayIdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // <-- Add this line


class PermitRequestController extends Controller
{
    // Show permits page
    public function index()
    {
        return view('permits');
    }

    // Store Barangay Clearance Request
    public function storeClearance(Request $request)
    {
        logger()->info('CSRF Token:', ['token' => $request->header('X-CSRF-TOKEN')]);

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'birthdate' => 'required|date',
            'age' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'date_requested' => 'required|date',
        ]);

        try {
            $clearance = BarangayClearanceRequest::create($validated);

            Log::info("New clearance request created: ID {$clearance->id}");

            return response()->json([
                'success' => true,
                'message' => 'Request submitted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating request: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error submitting request'
            ], 500);
        }
    }

    // Store Residency Request
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
            ResidencyRequest::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Request submitted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating residency request: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error submitting residency request'
            ], 500);
        }
    }

    // Get all requests from different types
    public function getRequests()
    {
        $clearance = BarangayClearanceRequest::select('id', 'full_name', 'status', 'created_at')
            ->get()
            ->map(function ($item) {
                $item->type = 'Barangay Clearance';
                return $item;
            });

        $residency = ResidencyRequest::select('id', 'full_name', 'status', 'created_at')
            ->get()
            ->map(function ($item) {
                $item->type = 'Certificate of Residency';
                return $item;
            });

        $business = BusinessPermitRequest::select('id', 'business_name as full_name', 'status', 'created_at')
            ->get()
            ->map(function ($item) {
                $item->type = 'Business Permit';
                return $item;
            });

        $idRequests = BarangayIdRequest::select('id', 'full_name', 'status', 'created_at')
            ->get()
            ->map(function ($item) {
                $item->type = 'Barangay ID';
                return $item;
            });

        $allRequests = $clearance
            ->merge($residency)
            ->merge($business)
            ->merge($idRequests);

        return response()->json($allRequests->sortByDesc('created_at')->values());
    }

    // Delete a request from any permit type
    public function delete($id)
    {
        $models = [
            BarangayClearanceRequest::class,
            ResidencyRequest::class,
            BusinessPermitRequest::class,
            BarangayIdRequest::class,
        ];

        foreach ($models as $model) {
            $record = $model::find($id);
            if ($record) {
                $record->delete();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Record not found'], 404);
    }
}
