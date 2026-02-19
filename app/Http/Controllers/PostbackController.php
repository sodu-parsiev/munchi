<?php

namespace App\Http\Controllers;

use App\Services\PostbackService;
use InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostbackController extends Controller
{
    public function __construct(
        private readonly PostbackService $postbackService
    ) {
    }

    public function handle(Request $request, string $provider = 'theoremreach'): JsonResponse
    {
        $expectedSecret = $this->expectedSecret($provider);

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

        try {
            $postback = $this->postbackService->createFromRequest($request, $provider);
        } catch (InvalidArgumentException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], 422);
        }

        return response()->json([
            'status' => 'ok',
            'provider' => $provider,
            'postback_id' => $postback->id,
        ]);
    }

    private function expectedSecret(string $provider): ?string
    {
        return match ($provider) {
            'theoremreach' => config('services.theoremreach.postback_secret'),
            default => null,
        };
    }
}
