<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'birthdate',
        'household_id',
        'relationship',
        'income_source',
        'contact'
    ];
    
    protected $casts = [
        'birthdate' => 'date:Y-m-d', // This will format the date without time
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public function household()
    {
        return $this->belongsTo(Household::class);
    }
    
}