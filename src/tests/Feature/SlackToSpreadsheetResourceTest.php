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
            ])->postJSON('/api/slack_to_spreadsheet', ['slack_channel_id' => 'C02ULAS9UGZ', 'spreadsheet_id' => '15FCfgn75FSde55LciB0UOx_BewOfzR6y1FGRXA4Q23U8', 'key_word' => '.*[朝の日報].*']);

        $response->assertStatus(201);
    }
}
