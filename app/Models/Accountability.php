<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Accountability extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'equipment_id',
        'assigned_date',
        'return_date',
        'notes',
        'assigned_by'
    ];

    protected $table = 'accountability';  // This line sets the table name explicitly

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}

