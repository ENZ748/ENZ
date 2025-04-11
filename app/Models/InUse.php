<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InUse extends Model
{
    use HasFactory;


    protected $fillable =[
        'itemID',
        'employeeID',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemID');
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employeeID');
    }
}
