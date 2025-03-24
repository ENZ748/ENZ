<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Item extends Model
{
    use HasFactory;

    protected $table = "itemstbl";
    protected $fillable = [
        'categoryID',
        'brandID',
        'unitID',
        'serial_number',
        'equipment_status',
        'date_purchased',
        'date_acquired',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brandID');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unitID');
    }
}
