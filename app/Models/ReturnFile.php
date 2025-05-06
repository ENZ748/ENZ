<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnFile extends Model
{
    use HasFactory;

    protected $table = 'return_file_items';

    protected $fillable = [
        'employeeID',
        'original_name',    
        'storage_path',
        'mime_type',
        'size',
        'returned_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employeeID');
    }

}