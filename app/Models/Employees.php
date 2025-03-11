<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employees extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'first_name',
        'last_name',
        'employee_number',
        'department', 
        'hire_date',
        'active'
    ];

    public function assigned()
    {
        return $this->hasMany(Assigned::class);
    }
}
