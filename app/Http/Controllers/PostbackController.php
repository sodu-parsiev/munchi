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

        $payload = $request->all();
        $clickDatetime = $request->input('click_datetime');

        $postback = Postback::create([
            'transaction_id' => $request->input('transaction_id'),
            'offer_id' => $request->input('offer_id'),
            'goal_id' => $request->input('goal_id'),
            'payout' => $request->input('payout'),
            'click_datetime' => $clickDatetime ? Carbon::parse($clickDatetime) : null,
            'payload' => $payload,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'ok',
            'postback_id' => $postback->id,
        ]);
    }
}
