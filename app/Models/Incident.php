<?php
// app/Models/Incident.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $table = 'incidents'; // Should match your table name    
  // In your Incident model
protected $fillable = [
    'incident_type', 
    'incident_date',
    'location',
    'description',
    'reporter_name',
    'reporter_contact',
    'status'
];

    protected $casts = [
        'incident_date' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'Pending', // Matches your ENUM default
    ];
}