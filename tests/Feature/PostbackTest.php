<?php

namespace Tests\Feature;

use App\Models\Postback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_postback_authentication_configuration(): void
    {
        config(['services.theoremreach.postback_secret' => null]);

        $response = $this->postJson('/api/postback', []);

        $response->assertStatus(500)->assertJson([
            'status' => 'error',
            'message' => 'Postback authentication is not configured.',
        ]);
    }

    public function test_it_rejects_requests_with_invalid_secret(): void
    {
        config(['services.theoremreach.postback_secret' => 'expected-secret']);

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

    public function test_it_persists_theoremreach_postback_and_macros(): void
    {
        config(['services.theoremreach.postback_secret' => 'expected-secret']);

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
            'provider' => 'theoremreach',
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
        $this->assertSame('theoremreach', $postback->payload['_provider']);

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

    public function test_it_supports_theoremreach_postbacks_with_field_mapping(): void
    {
        config([
            'services.theoremreach.postback_secret' => 'theoremreach-secret',
            'services.theoremreach.postback_field_map' => [
                'transaction_id' => 'conversion_id',
                'offer_id' => 'campaign_id',
                'goal_id' => 'event_id',
                'payout' => 'reward_amount',
                'click_datetime' => 'event_timestamp',
            ],
        ]);

        $payload = [
            'conversion_id' => 'trx-001',
            'campaign_id' => 'cmp-123',
            'event_id' => 'goal-8',
            'reward_amount' => '4.25',
            'event_timestamp' => '2024-08-09 10:11:12',
        ];

        $response = $this->withHeaders([
            'X-Postback-Secret' => 'theoremreach-secret',
        ])->postJson('/api/postback/theoremreach', $payload);

        $response->assertOk()->assertJson([
            'status' => 'ok',
            'provider' => 'theoremreach',
        ]);

        $this->assertDatabaseHas('postbacks', [
            'transaction_id' => 'trx-001',
            'offer_id' => 'cmp-123',
            'goal_id' => 'goal-8',
            'payout' => '4.25',
        ]);
    }

    public function test_it_rejects_postbacks_with_missing_required_fields(): void
    {
        config(['services.theoremreach.postback_secret' => 'expected-secret']);

        $response = $this->withHeaders([
            'X-Postback-Secret' => 'expected-secret',
        ])->postJson('/api/postback', [
            'transaction_id' => 'txn-123',
            'offer_id' => 'offer-456',
        ]);

        $response->assertStatus(422)->assertJson([
            'status' => 'error',
            'message' => 'Missing required postback fields: goal_id, payout',
        ]);

        $this->assertDatabaseCount('postbacks', 0);
        $this->assertDatabaseCount('postback_macros', 0);
    }

    public function test_it_rejects_mapped_postbacks_with_missing_required_fields(): void
    {
        config([
            'services.theoremreach.postback_secret' => 'theoremreach-secret',
            'services.theoremreach.postback_field_map' => [
                'transaction_id' => 'conversion_id',
                'offer_id' => 'campaign_id',
                'goal_id' => 'event_id',
                'payout' => 'reward_amount',
            ],
        ]);

        $response = $this->withHeaders([
            'X-Postback-Secret' => 'theoremreach-secret',
        ])->postJson('/api/postback/theoremreach', [
            'conversion_id' => 'trx-001',
            'campaign_id' => 'cmp-123',
            'event_id' => 'goal-8',
        ]);

        $response->assertStatus(422)->assertJson([
            'status' => 'error',
            'message' => 'Missing required postback fields: payout',
        ]);

        $this->assertDatabaseCount('postbacks', 0);
        $this->assertDatabaseCount('postback_macros', 0);
    }
}
