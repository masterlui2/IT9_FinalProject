<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        // Dummy credentials (Replace with database validation)
        $valid_id = "123";
        $valid_password = "123";

        // Validate input
        $request->validate([
            'id' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check credentials
        if ($request->id == $valid_id && $request->password == $valid_password) {
            // Store session and redirect to dashboard
            session(['user_id' => $request->id]);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Invalid ID or Password.');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
