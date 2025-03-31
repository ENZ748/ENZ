<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{   
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'activity_logs'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
