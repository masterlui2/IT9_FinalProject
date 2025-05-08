<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidencyRequest extends Model
{
    protected $fillable = [
        'full_name', 'birthdate', 'age', 'address',
        'contact_number', 'years_of_residency',
        'purpose', 'date_requested', 'status'
    ];
    }
