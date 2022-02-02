<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class MessageMediator
{

    // スプレッドシート挿入用Function
    static function insertSpreadsheet($insert_data)
    {
        // スプレッドシートを操作するGoogleClientインスタンスの生成（後述のファンクション）
        $sheets = MessageMediator::makeGoogleServiceSheetsInstance();

        // データを格納したい SpreadSheet のURLが
        // https://docs.google.com/spreadsheets/d/×××××××××××××××××××/edit#gid=0
        // である場合、××××××××××××××××××× の部分を以下に記入する
        $sheet_id = '15FCfgn75FSde55LciB0UOx_BewOfzR6y1FGRXA4Q23U';
        $range = 'A1:A10';
        $response = $sheets->spreadsheets_values->get($sheet_id, $range);
        // 格納する行の計算
        $row = count($response->getValues()) + 1;
        // データを整形（この順序でシートに格納される）
        $contact = [
            $insert_data['slack_team_id'],
            $insert_data['slack_channel_id'],
            $insert_data['slack_user_id'],
            $insert_data['message']
        ];
        $values = new ValueRange();
        $values->setValues([
            'values' => $contact
        ]);
        $sheets->spreadsheets_values->append(
            $sheet_id,
            'A'.$row,
            $values,
            ["valueInputOption" => 'USER_ENTERED']
        );

        return true;
    }

    // スプレッドシート操作用のインスタンスを生成するFunction
    public static function makeGoogleServiceSheetsInstance() {
        // storage/app/json フォルダに GCP からダウンロードした JSON ファイルを設置する
        $credentials_path = storage_path('app/json/credentials.json');
        $client = new Client();
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        return new Sheets($client);
    }

    // SlackEventAPIから送信されるチャレンジへの返答
    public static function ResponseSlackChallenge($request){
        if ($request['type'] == 'url_verification') {
            return response()->json($request['challenge']);
        }
    }


}
