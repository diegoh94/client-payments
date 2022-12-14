<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Uuids{

    public static function boot()    
    {
        parent::boot();
    
        static::creating(function (Model $model) {
    
    
            $model->setKeyType('string');
    
            $model->setIncrementing(false);
    
            $model->setAttribute($model->getKeyName(), Str::uuid());
    
        });
    }
    
}