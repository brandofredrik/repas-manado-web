<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'title',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsToMany(
            'App\Models\User',
            'user_has_role'
        );
    }

}