<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetForm extends Model
{
    use HasFactory;

    protected $table = 'asset_form';

    protected $fillable = [
        'employeeID',
        'assignedID',
        'issuance_number'
    ];


    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employeeID');
    }

    public function assignedItem()
    {
        return $this->belongsTo(AssignedItem::class, 'assignedID');
    }

    public function returnForm()
    {
        return $this->hasMany(ReturnForm::class, 'asset_formID');
    }

}