<?php

namespace App\Services;

use App\Models\Postback;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostbackService
{
    public function __construct(
        private readonly PostbackMacroService $postbackMacroService
    ) {
    }

    public function createFromRequest(Request $request, string $provider = 'theoremreach'): Postback
    {
        $payload = $request->all();
        $payload['_provider'] = $provider;

        $postback = new Postback();
        $postback->transaction_id = $this->input($request, $provider, 'transaction_id') ?? (string) Str::uuid();
        $postback->offer_id = $this->input($request, $provider, 'offer_id') ?? 'unknown';
        $postback->goal_id = $this->input($request, $provider, 'goal_id') ?? 'unknown';
        $postback->payout = $this->input($request, $provider, 'payout') ?? 0;

        $clickDatetime = $this->input($request, $provider, 'click_datetime');
        $postback->click_datetime = $clickDatetime ? Carbon::parse($clickDatetime) : now();

        $postback->payload = $payload;
        $postback->ip_address = $request->ip();
        $postback->user_agent = $request->userAgent();
        $postback->save();

        $this->postbackMacroService->createForPostback($postback, $payload);

        return $postback;
    }

    private function input(Request $request, string $provider, string $field): mixed
    {
        $fieldMap = config("services.{$provider}.postback_field_map", []);
        $mappedField = $fieldMap[$field] ?? $field;

        return $request->input($mappedField);
    }
}
