<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Equipments extends Model
{
    //
    use HasFactory;

    protected $fillable =
    [
        'equipment_name',
        'serial_number',
        'equipment_details',
        'date_purchased', 
        'date_acquired',
        'equipment_status'
    ];

    public function assigned()
    {
        return $this->hasMany(Accountability::class);
    }
    
    public function return_item()
    {
        return $this->hasMany(ReturnItem::class);
    }
}
