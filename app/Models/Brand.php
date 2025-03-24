<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brandtbl';

    protected $fillable = [
        'brand_name',
        'categoryID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }

    public function unit()
    {
        return $this->hasMany(Unit::class, 'brandID');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'brandID');
    }
}
