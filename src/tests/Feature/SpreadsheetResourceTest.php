<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpreadsheetResourceTest extends TestCase
{
    /**
     * Spreadsheetsリソースを登録しできることをテスト
     *
     * @return void
     */
    public function test_access_resource()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json'
            ])->postJSON('/api/spreadsheets', [
                'spreadsheet_id' => '15FCfgd36de55LciB0UOx_BewOfzR6y1FGRXA4Q23U', 
                'sheet_id' => '76244648', 
                'slack_user_id' => 'U9320KET'
            ]);

        $response->assertStatus(201);
    }
}
