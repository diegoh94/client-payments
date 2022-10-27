<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Uuids;
use App\Models\Client;

class Payment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'payment_date',
        'expires_at',
        'status',
        'client_id',
        'clp_usd'
    ];

    protected $casts = [
        'uuid' => 'string'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getKeyName()
    {
        return 'uuid';
    }
}
