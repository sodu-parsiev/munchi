<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::query()->findOrFail($validated['user_id']);

        $rewards = Reward::query()
            ->where('active', true)
            ->with(['variants' => function ($query) {
                $query->where('active', true);
            }])
            ->get();

        return response()->json([
            'status' => 'ok',
            'wallet_balance' => $user->wallet?->balance,
            'rewards' => $rewards,
        ]);
    }
}
