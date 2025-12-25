<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postback extends Model
{
    protected $fillable = [
        'transaction_id',
        'offer_id',
        'goal_id',
        'payout',
        'click_datetime',
        'payload',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'click_datetime' => 'datetime',
        'payload' => 'array',
        'payout' => 'decimal:2',
    ];
}
