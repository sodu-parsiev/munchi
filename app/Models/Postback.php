<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Postback extends Model
{
    protected $casts = [
        'click_datetime' => 'datetime',
        'payload' => 'array',
        'payout' => 'decimal:2',
    ];

    public function macros(): HasMany
    {
        return $this->hasMany(PostbackMacro::class);
    }
}
