<?php

namespace App\Models\Building;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $table = 'merchant_types';

    protected $fillable = [
        'title',
        'description'
    ];

    public $timestamps = false;

    public function price()
    {
        return $this->hasOne('App\Models\Building\price');
    }


}