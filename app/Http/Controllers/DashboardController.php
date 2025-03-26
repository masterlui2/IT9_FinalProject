<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('auth.dashboard.index');
    }

    public function residents() {
        return view('auth.dashboard.resident');
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

    // ✅ Add this for AJAX dynamic loading
    public function loadSection($section)
    {
        try {
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
