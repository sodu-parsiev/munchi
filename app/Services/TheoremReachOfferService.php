<?php

namespace App\Services;

use App\Services\Interfaces\OfferProvider;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TheoremReachOfferService implements OfferProvider
{
    public function fetchOffers(string $userId, array $identifiers = [], array $options = []): array
    {
        $apiKey = config('services.theoremreach.api_key');
        $secret = config('services.theoremreach.secret');

        if (! $apiKey) {
            Log::warning('TheoremReach offers request skipped due to missing credentials.', [
                'api_key_configured' => false,
            ]);

            return ['error' => 'Missing TheoremReach credentials.'];
        }

        $params = array_merge([
            'api_key' => $apiKey,
            'user_id' => $userId,
        ], $identifiers);

        if ($secret) {
            $params['signature'] = $this->signRequest($params, $secret);
        } else {
            Log::warning('TheoremReach offers request sent without signing secret.');
        }

        $url = $this->offersUrl();

        try {
            $response = Http::timeout($options['timeout'] ?? config('services.theoremreach.timeout', 10))
                ->acceptJson()
                ->get($url, $params);

            $response->throw();

            return $response->json();
        } catch (RequestException $exception) {
            Log::error('TheoremReach offers request failed.', [
                'url' => $url,
                'params' => $params,
                'status' => optional($exception->response)->status(),
                'body' => optional($exception->response)->body(),
                'message' => $exception->getMessage(),
            ]);

            return ['error' => 'Unable to fetch TheoremReach offers.'];
        }
    }

    private function signRequest(array $params, string $secret): string
    {
        ksort($params);

        return hash_hmac('sha256', http_build_query($params), $secret);
    }

    private function offersUrl(): string
    {
        $baseUrl = rtrim(config('services.theoremreach.base_url', 'https://api.theoremreach.com'), '/');
        $path = ltrim(config('services.theoremreach.offers_path', '/api/v1/offers'), '/');

        return $baseUrl.'/'.$path;
    }
}
