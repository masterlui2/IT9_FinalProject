<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'full_name',
        'data',
        'user_id',
        'status',
    ];
    

    // Add relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
