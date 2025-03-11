<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assigned extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'emploeey_id',
        'equipment_id',
        'assigned_date',
        'return_date',
        'notes',
        'assigned_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    
}
