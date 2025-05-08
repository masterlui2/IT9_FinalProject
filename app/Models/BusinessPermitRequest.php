<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPermitRequest extends Model
{
    protected $fillable = [
        'business_name', 'owner_name', 'business_address',
        'business_type', 'tin', 'dti_number',
        'date_applied', 'contact_number', 'status'
    ];
    }
