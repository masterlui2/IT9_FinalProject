<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BarangayClearanceRequest extends Model
{
    protected $fillable = [
        'full_name', 'birthdate', 'age', 'gender', 'civil_status',
        'address', 'contact_number', 'purpose', 'valid_id', 'date_requested', 'status'
    ];
}