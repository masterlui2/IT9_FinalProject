<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::all(); // You can also use paginate()
        return view('residents', compact('residents'));
    }
}