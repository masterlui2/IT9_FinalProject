<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class IncidentController extends Controller
{
   // app/Http/Controllers/IncidentController.php

   public function index()
   {
       try {
           $incidents = Incident::latest('incident_date')->get();
           
           // Debugging - can be removed later
           if (!isset($incidents)) {
               logger()->error('Incidents variable not set');
               $incidents = collect(); // Return empty collection
           }
           
           return view('auth.dashboard.incidents', compact('incidents'));
           
       } catch (\Exception $e) {
           logger()->error('Error loading incidents', [
               'error' => $e->getMessage(),
               'trace' => $e->getTraceAsString()
           ]);
           
           return view('auth.dashboard.incidents', [
               'incidents' => collect() // Empty collection as fallback
           ]);
       }
   }

// In IncidentController.php
public function store(Request $request)
{
    $validated = $request->validate([
        'incidentType' => 'required',
        'incidentDate' => 'required|date',
        'reporterName' => 'required',
        'reporterContact' => 'required',
        'location' => 'required',
        'description' => 'required',
        'status' => 'required|in:Pending,Ongoing,Resolved'
    ]);

    $incident = Incident::create([
        'incident_type' => $validated['incidentType'],
        'incident_date' => $validated['incidentDate'],
        'reporter_name' => $validated['reporterName'],
        'reporter_contact' => $validated['reporterContact'],
        'location' => $validated['location'],
        'description' => $validated['description'],
        'status' => $validated['status']
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Incident reported successfully!',
        'incident' => $incident, 
    ]);
}
public function edit(Incident $incident)
{
    return response()->json([
        'success' => true,
        'incident' => $incident
    ]);
}
public function update(Request $request, Incident $incident)
{
    $validated = $request->validate([
        'incidentType' => 'required',
        'incidentDate' => 'required|date',
        'reporterName' => 'required',
        'reporterContact' => 'required',
        'location' => 'required',
        'description' => 'required',
        'status' => 'required|in:Pending,Ongoing,Resolved'
    ]);

    $incident->update([
        'incident_type' => $validated['incidentType'],
        'incident_date' => $validated['incidentDate'],
        'reporter_name' => $validated['reporterName'],
        'reporter_contact' => $validated['reporterContact'],
        'location' => $validated['location'],
        'description' => $validated['description'],
        'status' => $validated['status']
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Incident updated successfully!',
        'incident' => $incident
    ]);
}
public function destroy(Incident $incident)
{
    $incident->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'Incident deleted successfully!'
    ]);
}
}