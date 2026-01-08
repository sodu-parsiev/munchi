<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdGemOfferService
{
    public function fetchOffers(string $userId, array $identifiers = [], array $options = []): array
    {
        $publisherId = config('services.adgem.publisher_id');
        $apiKey = config('services.adgem.api_key');
        $secret = config('services.adgem.secret');

        if (!$publisherId || !$apiKey) {
            Log::warning('AdGem offers request skipped due to missing credentials.', [
                'publisher_id_configured' => (bool) $publisherId,
                'api_key_configured' => (bool) $apiKey,
            ]);

            return ['error' => 'Missing AdGem credentials.'];
        }

        $params = array_merge([
            'publisher_id' => $publisherId,
            'api_key' => $apiKey,
            'user_id' => $userId,
        ], $identifiers);

        if ($secret) {
            $params['signature'] = $this->signRequest($params, $secret);
        } else {
            Log::warning('AdGem offers request sent without signing secret.');
        }

        $url = $this->offersUrl();

        try {
            $response = Http::timeout($options['timeout'] ?? config('services.adgem.timeout', 10))
                ->acceptJson()
                ->get($url, $params);

            $response->throw();

            return $response->json();
        } catch (RequestException $exception) {
            Log::error('AdGem offers request failed.', [
                'url' => $url,
                'params' => $params,
                'status' => optional($exception->response)->status(),
                'body' => optional($exception->response)->body(),
                'message' => $exception->getMessage(),
            ]);

            return ['error' => 'Unable to fetch AdGem offers.'];
        }
    }

    private function signRequest(array $params, string $secret): string
    {
        ksort($params);

        return hash_hmac('sha256', http_build_query($params), $secret);
    }

    private function offersUrl(): string
    {
        $baseUrl = rtrim(config('services.adgem.base_url', 'https://api.adgem.com/v1'), '/');
        $path = ltrim(config('services.adgem.offers_path', '/offers'), '/');

        return $baseUrl.'/'.$path;
    }
}
