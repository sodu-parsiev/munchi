<?php

namespace App\Services;

use App\Models\RewardVariant;

class RewardVariantService
{
    public function create(array $data): RewardVariant
    {
        return RewardVariant::create([
            'reward_id' => $data['reward_id'],
            'amount' => $data['amount'],
            'price' => $data['price'],
            'currency' => $data['currency'],
            'active' => $data['active'] ?? true,
        ]);
    }

    public function update(RewardVariant $variant, array $data): RewardVariant
    {
        $variant->fill([
            'reward_id' => $data['reward_id'] ?? $variant->reward_id,
            'amount' => $data['amount'] ?? $variant->amount,
            'price' => $data['price'] ?? $variant->price,
            'currency' => $data['currency'] ?? $variant->currency,
            'active' => $data['active'] ?? $variant->active,
        ]);
        $variant->save();

        return $variant;
    }
}
