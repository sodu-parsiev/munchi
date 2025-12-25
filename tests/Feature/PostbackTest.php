<?php

namespace Tests\Feature;

use App\Models\Postback;
use App\Models\PostbackMacro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_postback_authentication_configuration(): void
    {
        config(['services.postback.shared_secret' => null]);

        $response = $this->postJson('/api/postback', []);

        $response->assertStatus(500)->assertJson([
            'status' => 'error',
            'message' => 'Postback authentication is not configured.',
        ]);
    }

    public function test_it_rejects_requests_with_invalid_secret(): void
    {
        config(['services.postback.shared_secret' => 'expected-secret']);

        $response = $this->postJson('/api/postback', [], [
            'X-Postback-Secret' => 'wrong-secret',
        ]);

        $response->assertStatus(401)->assertJson([
            'status' => 'error',
            'message' => 'Unauthorized postback request.',
        ]);

        $this->assertDatabaseCount('postbacks', 0);
        $this->assertDatabaseCount('postback_macros', 0);
    }

    public function test_it_persists_postback_and_macros(): void
    {
        config(['services.postback.shared_secret' => 'expected-secret']);

        $payload = [
            'transaction_id' => 'txn-123',
            'offer_id' => 'offer-456',
            'goal_id' => 'goal-789',
            'payout' => '9.75',
            'click_datetime' => '2024-01-02 03:04:05',
            'meta' => ['source' => 'email', 'campaign' => 'spring'],
            'subid' => 'abc123',
        ];

        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->withHeaders([
                'X-Postback-Secret' => 'expected-secret',
                'User-Agent' => 'Postback Test Agent',
            ])
            ->postJson('/api/postback', $payload);

        $response->assertOk()->assertJson([
            'status' => 'ok',
        ]);

        $postback = Postback::query()->first();

        $this->assertNotNull($postback);
        $this->assertSame('txn-123', $postback->transaction_id);
        $this->assertSame('offer-456', $postback->offer_id);
        $this->assertSame('goal-789', $postback->goal_id);
        $this->assertSame('9.75', $postback->payout);
        $this->assertSame('2024-01-02 03:04:05', $postback->click_datetime->format('Y-m-d H:i:s'));
        $this->assertSame('203.0.113.10', $postback->ip_address);
        $this->assertSame('Postback Test Agent', $postback->user_agent);
        $this->assertSame($payload, $postback->payload);

        $this->assertDatabaseCount('postback_macros', count($payload));
        $this->assertDatabaseHas('postback_macros', [
            'postback_id' => $postback->id,
            'macro_name' => 'meta',
            'macro_value' => json_encode($payload['meta']),
        ]);
        $this->assertDatabaseHas('postback_macros', [
            'postback_id' => $postback->id,
            'macro_name' => 'subid',
            'macro_value' => 'abc123',
        ]);
    }
}
