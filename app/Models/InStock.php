<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InStock extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = '_in_stock';

    // Define the fillable properties to protect from mass-assignment vulnerabilities
    protected $fillable = [
        'employeeID',
        'itemID',
        'status'
    ];

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
