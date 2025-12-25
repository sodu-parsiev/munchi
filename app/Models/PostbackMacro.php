<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostbackMacro extends Model
{
    protected $fillable = [
        'postback_id',
        'macro_name',
        'macro_value',
    ];

    public function postback(): BelongsTo
    {
        return $this->belongsTo(Postback::class);
    }
}
