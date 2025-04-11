<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DamagedItem extends Model
{
    use HasFactory;

    protected $table = 'damaged_items';

    protected $fillable=[
        'itemID',
        'status',
        'quantity'
    ];      

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemID');
    }
}
