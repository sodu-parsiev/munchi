<?php

namespace App\Services\Interfaces;

interface OfferProvider
{
    public function fetchOffers(string $userId, array $identifiers = [], array $options = []): array;
}
