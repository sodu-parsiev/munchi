<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardVariant extends Model
{
    /** @use HasFactory<\Database\Factories\RewardVariantFactory> */
    use HasFactory;

    protected $fillable = [
        'reward_id',
        'amount',
        'price',
        'currency',
        'active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'price' => 'integer',
        'active' => 'boolean',
    ];

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}
