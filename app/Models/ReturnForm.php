<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnForm extends Model
{
    use HasFactory;

    protected $table = 'return_form';

    protected $fillable = [
        'employeeID',
        'returnID',
        'issuance_number'
    ];


    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employeeID');
    }

    public function returnItem()
    {
        return $this->belongsTo(ItemHistory::class, 'returnID');
    }

}
