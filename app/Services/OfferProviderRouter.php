<?php

namespace App\Services;

use App\Services\Interfaces\OfferProvider;
use InvalidArgumentException;

class OfferProviderRouter
{
    /**
     * @var array<string, class-string<OfferProvider>>
     */
    private array $providerMap;

    public function __construct()
    {
        $this->providerMap = [
            'adgem' => AdGemOfferService::class,
            'theoremreach' => TheoremReachOfferService::class,
        ];
    }

    public function resolve(string $provider): OfferProvider
    {
        $normalizedProvider = strtolower($provider);
        $providerClass = $this->providerMap[$normalizedProvider] ?? null;

        if (! $providerClass) {
            throw new InvalidArgumentException(sprintf('Unsupported offer provider [%s].', $provider));
        }

        return app($providerClass);
    }
}
