<?php

namespace App\Models\Building;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    protected $table = 'merchant_building_prices';

    protected $fillable = [
        'title',
        'description',
        'price',
        'type_id'
    ];

    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo('App\Models\Building\Type');
    }

    public function building()
    {
        return $this->hasMany('App\Models\Merchant\Building');
    }


}