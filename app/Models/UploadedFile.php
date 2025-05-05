<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'storage_path',
        'mime_type',
        'size',
        'employeeID'
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}