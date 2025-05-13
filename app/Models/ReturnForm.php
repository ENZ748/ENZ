<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnForm extends Model
{
    use HasFactory;

    protected $table = 'return_form';

    protected $fillable = [
        'asset_formID',
        'issuance_number'
    ];


    public function asset_form()
    {
        return $this->belongsTo(AssetForm::class, 'asset_formID');
    }

    public function returnItem()
    {
        return $this->belongsTo(ItemHistory::class, 'returnID');
    }

}
