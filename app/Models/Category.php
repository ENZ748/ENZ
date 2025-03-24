<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorytbl';    

    protected $fillable = [
        'category_name'
    ];

    // Category has many brands (but brands belong to categories)
    public function brands()
    {
        return $this->hasMany(Brand::class, 'categoryID');
    }


    // Category has many items (but items belong to categories)
    public function items()
    {
        return $this->hasMany(Item::class, 'categoryID');
    }
}
