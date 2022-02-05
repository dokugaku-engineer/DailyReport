<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SlackPostsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->withHeaders(['Content-Type' => 'application/json'])
            ->postJSON('/api/slack_posts', [
                'type' => 'event_callback',
                'team_id' => 'T02P6LCQ2BZ',
                'event' => [
                    'channel' => 'C02ULAS9UGZ',
                    'user' => 'U02PM9L823C',
                    'text' => '[日報]test'
                ]
            ]);

        $response->assertStatus(201);
    }
}
