<?php

namespace App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{

    protected $table = 'merchant_buildings';

    protected $fillable = [
        'register_number',
        'name',
        'description',
        'widht',
        'length',
        'price_id',
        'market_id',
        'due_day',
        'due_month'
    ];

    public $timestamps = false;

    public function owner() {
        return $this->belongsToMany(
            'App\Models\Merchant\Owner',
            'owner_has_building'
        );
    }

    public function price()
    {
        return $this->belongsTo('App\Models\Building\Price');
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Market');
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }

}