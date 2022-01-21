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
        $response = $this->post('/api/v1.0/slack');

        $response->assertStatus(200);
    }

    public function test_create_resource()
    {       
            $team_id = 'U02PM9L823C';
            $channel_id = ['slack_channel_id'=>'C02ULAS9UGZ'];
            $user_id = ['slack_user_id'=>'U02PM9L823C'];
            $slack_team_model = new SlackTeam;
            $result_of_save_record = $slack_team_model->create([
                'slack_team_id' => $team_id 
            ]);
            $result_of_save_record->associateSlackChannels()->create($channel_id);
            $result_of_save_record->associateSlackUsers()->create($user_id);

            $this -> assertModelExists($result_of_save_record);
    }
}
