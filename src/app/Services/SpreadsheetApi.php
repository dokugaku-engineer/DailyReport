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
     * スプレッドシートへ書き込みを行う
     * @param string $slack_message Slackから送られてきたメッセージ
     * @param string $spreadsheet_id 連携先スプレッドシートのID
     * @param string $sheet_id 連携先シートのID
     * @return bool true
     */
    public static function insertSpreadsheet(string $slack_message, string $spreadsheet_id, string $sheet_id): bool
    {
        $sheets = SpreadsheetApi::makeSheetsClient();

        $sheet_name = SpreadsheetApi::getSheetName($sheet_id, $spreadsheet_id, $sheets);
        $post_row = SpreadsheetApi::getRow($sheet_name, $spreadsheet_id, $sheets);
        $values = SpreadsheetApi::setValues($slack_message);

        try {
            $sheets->spreadsheets_values->append($spreadsheet_id, $sheet_name.'!A'.$post_row, $values, ["valueInputOption" => 'USER_ENTERED']);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * sheetsクライアントを作成する
     * @return Sheets
     */
    public static function makeSheetsClient(): Sheets
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
    public static function getSheetName(string $sheet_id, string $spreadsheet_id, Sheets $sheets_client): string
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
    public static function getRow(string $sheet_name, string $spreadsheet_id, Sheets $sheets_client): int
    {
        $range = $sheet_name;
        $response = $sheets_client->spreadsheets_values->get($spreadsheet_id, $range);

        return count($response->getValues()) + 1;
    }

    /**
     * シートに書き込む値をセットする
     * @param string $slack_message slackから送られて来たメッセージ
     * @return ValueRange $values
     */
    public static function setValues(string $slack_message): ValueRange
    {
        $values = new ValueRange();
        $values->setValues([
            'values' => [date('Y年n月j日'), $slack_message]
        ]);

        return $values;
    }
}
