<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\SlackToSpreadsheet;
use App\Models\SlackChannel;
use App\Models\Spreadsheet;

class SlackToSpreadsheetResourceTest extends TestCase
{
    /**
     * slack_to_spreadsheetリソースへ登録しできることをテスト
     *
     * @return void
     */
    public function test_access_resource()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
            ])->postJSON('/api/slack_to_spreadsheet', ['slack_channel_id' => 'channel1', 'spreadsheet_id' => '1vB6hlCx_aitiNQw2Um_J0WnNnR6ZDbgjZi6BEB2K6X8', 'key_word' => '.*[日報].*']);

        $response->assertStatus(201);
    }
}
