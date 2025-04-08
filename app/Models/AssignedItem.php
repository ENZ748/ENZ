<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedItem extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'assigned_items';

    // Define the fillable properties to protect from mass-assignment vulnerabilities
    protected $fillable = [
        'employeeID',
        'itemID',
        'notes',
        'assigned_date',
        'item_status',
        'assigned_by'
    ];

    // If you want to handle the assigned_date as a date
    protected $dates = ['assigned_date'];

    // Relationships

    // Each AssignedItem belongs to an Employee
    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employeeID');
    }

    // Each AssignedItem belongs to an Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'itemID');
    }
}
