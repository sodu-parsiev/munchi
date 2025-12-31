<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Redemption extends Model
{
    /** @use HasFactory<\Database\Factories\RedemptionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_variant_id',
        'points_spent',
        'status',
        'external_reference',
    ];

    protected $casts = [
        'points_spent' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rewardVariant(): BelongsTo
    {
        return $this->belongsTo(RewardVariant::class);
    }
}
