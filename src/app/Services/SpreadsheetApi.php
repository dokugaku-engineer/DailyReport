<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SlackPostsRequest;
use Exception;

class SpreadsheetApi
{
    /**
     * インスタンス生成時に値が割当られる変数
     * @param string $message Slackから送られてきたメッセージ
     * @param string $spreadsheet_id 連携先スプレッドシートのID
     * @param string $sheet_id 連携先シートのID
     */
    protected $message;
    protected $spreadsheet_id;
    protected $sheet_id;

    /**
     * スプレッドシートへ書き込みを行う
     * @param string $spreadsheet_id 連携先スプレッドシートのID
     * @param string $sheet_id 連携先シートのID
     */
    public function __construct(string $spreadsheet_id, string $sheet_id)
    {
        $this->spreadsheet_id = $spreadsheet_id;
        $this->sheet_id = $sheet_id;
    }
    /**
     * スプレッドシートへ書き込みを行う
     * @param string $message Slackから送られてきたメッセージ
     * @return void
     */
    public function insertSpreadsheet(string $message): void
    {
        $sheets = $this->makeSheets();

        $sheet_name = $this->getSheetName($this->sheet_id, $this->spreadsheet_id, $sheets);
        $insert_row = $this->calculateInsertRow($sheet_name, $this->spreadsheet_id, $sheets);
        $values = $this->setValues($message);
        try {
            $sheets->spreadsheets_values->append($this->spreadsheet_id, $sheet_name.'!A'.$insert_row, $values, ["valueInputOption" => 'USER_ENTERED']);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * sheetsクライアントを作成する
     * @return Sheets
     */
    public function makeSheets(): Sheets
    {
        $credentials_path = storage_path('app/json/credentials.json');
        $client = new Client();
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);

        return new Sheets($client);
    }

    /**
     * シート名を取得する
     * @param string $sheet_id スプレッドシートのシートID
     * @param string $spreadsheet_id 連携先スプレッドシートのID
     * @param Sheets $sheets_client スプレッドシート操作クライアント
     * @return string $sheet_name[$sheet_id] 対象のシート名
     */
    public function getSheetName(string $sheet_id, string $spreadsheet_id, Sheets $sheets_client): string
    {
        $spreadsheet_info = $sheets_client->spreadsheets->get($spreadsheet_id);
        $sheets_name = [];
        foreach ($spreadsheet_info as $item) {
            $id = $item['properties']['sheetId'];
            $sheet_title = $item['properties']['title'];
            $sheets_name[$id] = $sheet_title;
        }

        return $sheets_name[$sheet_id];
    }

    /**
     * 書き込み行を取得する
     * @param string $sheet_name スプレッドシートのシート名
     * @param string $spreadsheet_id 連携先スプレッドシートのID
     * @param Sheets $sheets_client スプレッドシート操作クライアント
     * @return int 書き込み行番号
     */
    public function calculateInsertRow(string $sheet_name, string $spreadsheet_id, Sheets $sheets_client): int
    {
        $response = $sheets_client->spreadsheets_values->get($spreadsheet_id, $sheet_name);

        return count($response->getValues()) + 1;
    }

    /**
     * シートに書き込む値をセットする
     * @param string $slack_message slackから送られて来たメッセージ
     * @return ValueRange $values
     */
    public function setValues(string $slack_message): ValueRange
    {
        $values = new ValueRange();
        $values->setValues([
            'values' => [date('Y年n月j日'), $slack_message]
        ]);

        return $values;
    }
}
