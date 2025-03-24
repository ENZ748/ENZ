<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;


    protected $table = 'units';
    // Define the attributes that are mass assignable
    protected $fillable = [
        'unit_name',
        'brandID'
    ];

    // Relationship: A unit belongs to a category
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandID');
    }

    // Relationship: A unit has many items
    public function items()
    {
        return $this->hasMany(Item::class, 'unitID');
    }
}
