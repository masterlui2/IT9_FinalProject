<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayIdRequest extends Model
{
    protected $fillable = [
        'full_name', 'birthdate', 'gender', 'civil_status',
        'citizenship', 'contact_number', 'address',
        'emergency_contact_name', 'emergency_contact_number',
        'photo_path', 'status'
    ];
    }
