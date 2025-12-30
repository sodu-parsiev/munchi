<?php

namespace App\Http\Controllers;

use App\Services\PostbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostbackController extends Controller
{
    public function __construct(
        private readonly PostbackService $postbackService
    ) {
    }

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

        $postback = $this->postbackService->createFromRequest($request);

        return response()->json([
            'status' => 'ok',
            'postback_id' => $postback->id,
        ]);
    }
}
