<?php

namespace App\Services;

use App\Models\Postback;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostbackService
{
    public function __construct(
        private readonly PostbackMacroService $postbackMacroService
    ) {
    }

    public function createFromRequest(Request $request): Postback
    {
        $payload = $request->all();
        $clickDatetime = $request->input('click_datetime');

        $postback = new Postback();
        $postback->transaction_id = $request->input('transaction_id');
        $postback->offer_id = $request->input('offer_id');
        $postback->goal_id = $request->input('goal_id');
        $postback->payout = $request->input('payout');
        $postback->click_datetime = $clickDatetime ? Carbon::parse($clickDatetime) : null;
        $postback->payload = $payload;
        $postback->ip_address = $request->ip();
        $postback->user_agent = $request->userAgent();
        $postback->save();

        $this->postbackMacroService->createForPostback($postback, $payload);

        return $postback;
    }
}
