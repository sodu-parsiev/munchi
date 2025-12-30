<?php

namespace App\Services;

use App\Models\Reward;

class RewardService
{
    public function create(array $data): Reward
    {
        return Reward::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'active' => $data['active'] ?? true,
            'provider' => $data['provider'] ?? null,
            'sku' => $data['sku'] ?? null,
        ]);
    }

    public function update(Reward $reward, array $data): Reward
    {
        $reward->fill([
            'name' => $data['name'] ?? $reward->name,
            'description' => $data['description'] ?? $reward->description,
            'active' => $data['active'] ?? $reward->active,
            'provider' => $data['provider'] ?? $reward->provider,
            'sku' => $data['sku'] ?? $reward->sku,
        ]);
        $reward->save();

        return $reward;
    }
}
