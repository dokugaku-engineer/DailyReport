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
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_resource()
    {
        $response = $this->postJSON('/api/slack', ['team_id' => 'U03GB423C', 'channel_id' => 'C03KIES9UGZ', 'user_id' => 'U06KQD823C']);

        $response->assertStatus(200);
    }

    public function test_create_resource()
    {       
            $team_id = 'U03GB423C';
            $channel_id = 'C03KIES9UGZ';
            $user_id = 'U06KQD823C';

            $saved_slack_team = SlackTeam::firstOrCreate(['slack_team_id' => $team_id]);
            $saved_slack_team->slackChannels()->firstOrCreate(['slack_channel_id' => $channel_id]);
            $saved_slack_team->slackUsers()->firstOrCreate(['slack_user_id' => $user_id]);

            $this -> assertModelExists($saved_slack_team);
    }
}
