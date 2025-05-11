<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangayClearance extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'birthdate',
        'age',
        'gender',
        'civil_status',
        'address',
        'contact_number',
        'purpose',
        'status' // default 'pending'
    ];}
