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
        'active',
        'user_id'
    ];

    public function assigned()
    {
        return $this->hasMany(Accountability::class);
    }

    public function return_item()
    {
        return $this->hasMany(ReturnItem::class);
    }

    public function assigned_items()
    {
        return $this->hasMany(AssignedItem::class, 'employeeID');
    }

    public function item_history()
    {
        return $this->hasMany(ItemHistory::class, 'employeeID');
    }   

    public function in_stock()
    {
        return $this->hasMany(InStock::class, 'employeeID');
    }

    public function in_use()
    {
        return $this->hasMany(InUse::class, 'employeeID');
    }



    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
