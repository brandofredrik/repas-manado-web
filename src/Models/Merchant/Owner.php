<?php

namespace App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{

    protected $table = 'merchant_owners';

    protected $fillable = [
        'name',
        'phone',
        'identity_type',
        'identity_number'
    ];

    public $timestamps = false;

    public function building() {
        return $this->belongsToMany(
            'App\Models\Merchant\Building',
            'owner_has_building'
        );
    }

}