<?php

namespace App\Http\Controllers;

use App\Models\RewardVariant;
use App\Models\User;
use App\Services\RedemptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function __construct(
        private readonly RedemptionService $redemptionService
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'reward_variant_id' => ['required', 'exists:reward_variants,id'],
            'status' => ['nullable', 'string'],
            'external_reference' => ['nullable', 'string'],
        ]);

        $user = User::query()->findOrFail($validated['user_id']);
        $rewardVariant = RewardVariant::query()->findOrFail($validated['reward_variant_id']);

        $redemption = $this->redemptionService->redeem(
            $user,
            $rewardVariant,
            $validated['status'] ?? 'pending',
            $validated['external_reference'] ?? null
        );

        return response()->json([
            'status' => 'ok',
            'redemption' => $redemption->load('rewardVariant.reward'),
            'wallet_balance' => $user->wallet?->balance,
        ], 201);
    }
}
