<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PermitController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidentController;

    //Incidents route
    Route::resource('incidents', IncidentController::class);
    Route::get('/dashboard/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::post('/dashboard/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::delete('/incidents/{incident}', [IncidentController::class, 'destroy'])->name('incidents.destroy');
    Route::get('/debug-incidents', function() {
        try {
            $data = [
                'incidents_exists' => isset($incidents),
                'incidents_count' => \App\Models\Incident::count(),
                'view_path' => realpath(resource_path('views/auth/dashboard/incidents.blade.php')),
                'config' => config('app.debug')
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
     // Permit Form Submission Routes
    Route::prefix('permits')->group(function () {
    Route::resource('residents', ResidentController::class);
    Route::post('/permits/id/store', [PermitController::class, 'storeBarangayId'])->name('permits.id.store');
    Route::post('/residency', [PermitController::class, 'storeResidency'])->name('permits.residency.store');
    Route::post('/clearance', [PermitController::class, 'storeClearance'])->name('permits.clearance.store');
    Route::post('/business', [PermitController::class, 'storeBusiness'])->name('permits.business.store');
    Route::post('/id', [PermitController::class, 'storeId'])->name('permits.id.store');
    Route::post('/permits/clearance/store', [PermitController::class, 'storeClearance'])->name('permits.clearance.store');
    Route::post('/permits/id/store', [PermitController::class, 'storeId'])->name('permits.id.store');

    // Permit routes
    Route::get('/', [PermitController::class, 'getMyRequests'])->name('api.permits.index');
    Route::get('/{id}', [PermitController::class, 'show'])->name('api.permits.show');
    Route::put('/{id}/approve', [PermitController::class, 'approve'])->name('api.permits.approve');
    Route::delete('/{id}', [PermitController::class, 'destroy'])->name('api.permits.destroy');
    });

    // Routes that require session (web middleware)
    Route::middleware(['web'])->group(function () {
    Route::get('/api/permits', [PermitController::class, 'getMyRequests'])->name('api.permits.index');

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/residents', [DashboardController::class, 'residents'])->name('resident.info');
    Route::get('/dashboard/permits', [DashboardController::class, 'permits'])->name('business.permits');
    Route::get('/dashboard/incidents', [DashboardController::class, 'incidents'])->name('incident.logs');
    Route::get('/dashboard/view/{section}', [DashboardController::class, 'loadSection']);
    });

    // Miscellaneous Routes
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login'); // Redirects to login page
    })->name('logout');

    Route::get('/test-resident', function() {
        return response()->json([
            'test' => true,
            'message' => 'API is working'
        ]);
    });
    Route::get('/households/{household}/heads', function ($householdId) {
        return \App\Models\Resident::where('household_id', $householdId)
            ->where('relationship', 'Head')
            ->get(['id', 'full_name']);
    });
    Route::get('/api/residents/{resident}', [ResidentController::class, 'show']);

    // Consolidated Resident Routes
    Route::prefix('residents')->group(function () {
    Route::put('/residents/{resident}', [ResidentController::class, 'update']);
    Route::get('/', [ResidentController::class, 'index']);
    Route::get('/{id}', [ResidentController::class, 'show'])->name('residents.show');
    Route::post('/', [ResidentController::class, 'store'])->name('residents.store');
    Route::put('/{id}', [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('/{id}', [ResidentController::class, 'destroy']);
    });

    // Auth routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
