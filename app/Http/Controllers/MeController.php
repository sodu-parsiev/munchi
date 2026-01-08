<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            $validated = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
            ]);

            $user = User::query()->findOrFail($validated['user_id']);
        }

        return response()->json([
            'status' => 'ok',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'points_balance' => $user->points_balance,
            ],
        ]);
    }
}
