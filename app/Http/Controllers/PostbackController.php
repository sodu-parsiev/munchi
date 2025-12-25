<?php

namespace App\Http\Controllers;

use App\Models\Postback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostbackController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $expectedSecret = config('services.postback.shared_secret');

        if (! $expectedSecret) {
            return response()->json([
                'status' => 'error',
                'message' => 'Postback authentication is not configured.',
            ], 500);
        }

        $providedSecret = (string) $request->header('X-Postback-Secret', '');

        if (! hash_equals($expectedSecret, $providedSecret)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized postback request.',
            ], 401);
        }

        $validated = $request->validate([
            'transaction_id' => ['required', 'string', 'max:255'],
            'offer_id' => ['required', 'string', 'max:255'],
            'goal_id' => ['required', 'string', 'max:255'],
            'payout' => ['required', 'numeric', 'min:0'],
            'click_datetime' => ['required', 'date'],
        ]);

        $postback = Postback::create([
            'transaction_id' => $validated['transaction_id'],
            'offer_id' => $validated['offer_id'],
            'goal_id' => $validated['goal_id'],
            'payout' => $validated['payout'],
            'click_datetime' => Carbon::parse($validated['click_datetime']),
            'payload' => $request->all(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'ok',
            'postback_id' => $postback->id,
        ]);
    }
}
