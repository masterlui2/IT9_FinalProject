<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident; // <-- Make sure this is imported

class DashboardController extends Controller
{
    public function index() {
        return view('auth.dashboard.index');
    }

    public function residents() {
        $residents = Resident::all();
        return view('auth.dashboard.residents', compact('residents'));
    }

    public function households() {
        return view('auth.dashboard.household');
    }

    public function documents() {
        return view('auth.dashboard.documents');
    }

    public function permits() {
        return view('auth.dashboard.permits');
    }

    public function incidents() {
        return view('auth.dashboard.incidents');
    }

    // ✅ For AJAX dynamic loading
    public function loadSection($section)
    {
        try {
            // Special handling for "residents" to pass data
            if ($section === 'residents') {
                $residents = Resident::all();
                return view("auth.dashboard.residents", compact('residents'));
            }

            // For other sections, just load the view
            $view = "auth.dashboard.$section";
            if (view()->exists($view)) {
                return view($view);
            } else {
                return response("View '$view' not found.", 404);
            }
        } catch (\Exception $e) {
            return response("Error loading section: " . $e->getMessage(), 500);
        }
    }
}
