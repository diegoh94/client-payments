<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $casts = [
        'join_date'  => 'datetime:Y-m-d'
    ];

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
