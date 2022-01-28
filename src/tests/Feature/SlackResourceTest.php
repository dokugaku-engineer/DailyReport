<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SlackTeam;
use App\Models\SlackChannel;
use App\Models\SlackUser;

class SlackResourceTest extends TestCase
{
    /**
     * Slackリソースへ登録しできることをテスト
     *
     * @return void
     */
    public function test_access_resource()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
            ])->postJSON('/api/slack', ['team_id' => 'U054BC', 'channel_id' => 'C6KG53Z', 'user_id' => 'U08R23C']);

        $response->assertStatus(201);
    }
}
