<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SlackTeam;
use App\Models\SlackChannel;
use App\Models\SlacUser;
use App\Models\SlacToSpreadsheet;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class SlackMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slack_users_id',
        'slack_teams_id',
        'slack_channels_id',
        'message'
    ];

    /**
     * slack_postsリソースの登録に必要なデータを取得する
     * @param string $team_id slackのチームのID
     * @param string $user_id slackのチャンネルID
     * @param string $channel_id slackのユーザーID
     * @param string $message slackから送られてくるメッセージ
     * @return array slack_posts_column slack_messageテーブルに保存するデータ一式
     */
    public static function readySlackPostsResources(string $team_id, string $user_id, string $channel_id, string $message): array
    {
        $slack_posts_column = array();

        $slack_posts_column['slack_teams_id'] = DB::table('slack_teams')->where('slack_team_id', $team_id)->value('id');
        $slack_posts_column['slack_channels_id'] = DB::table('slack_channels')->where('slack_channel_id', $channel_id)->where('slack_teams_id', $slack_posts_column['slack_teams_id'])->value('id');
        $slack_posts_column['slack_users_id'] = DB::table('slack_users')->where('slack_user_id', $user_id)->where('slack_teams_id', $slack_posts_column['slack_teams_id'])->value('id');
        $slack_posts_column['message'] = $message;

        SlackMessage::checkColumnItems($slack_posts_column);

        return $slack_posts_column;
    }

    /**
     * slackから投稿されたメッセージの連携情報を取得する
     * @param int $slack_channels_id slack_channelテーブルのID
     * @return array $slack_to_spreadsheet_column メッセージ連携に必要な情報
     */
    public static function getSlackToSpreadsheetInfo(int $slack_channels_id): array
    {
        $slack_to_spreadsheet_column = array();

        $slack_to_spreadsheet_column['spreadsheets_id'] = DB::table('slack_to_spreadsheet')->where('slack_channels_id', $slack_channels_id)->value('spreadsheets_id');
        $slack_to_spreadsheet_column['key_word'] = DB::table('slack_to_spreadsheet')->where('slack_channels_id', $slack_channels_id)->value('key_word');

        SlackMessage::checkColumnItems($slack_to_spreadsheet_column);

        return $slack_to_spreadsheet_column;
    }

    /**
     * 日報として扱うかキーワードをチェックする
     * @param string $key_word 日報投稿のトリガーとなる文字列
     * @param string $message slackから送られて来たメッセージ
     * @return void
     */
    public static function checkKeyWord(string $key_word, string $message)
    {
        if (preg_match('/'.$key_word.'/', $message) == 0) {
            $response = response()->json([
                'status' => 400,
                'error' => 'Bad Request',
            ], 400);
            throw new HttpResponseException($response);
        }
    }

    /**
     * 関連するスプレッドシートのシートIDを取得する
     * @param int $spreadsheets_id SpreadsheetsテーブルのID
     * @return string $spreadsheet_id SpreadsheetのID
     */
    public static function getSpreadsheetId(int $spreadsheets_id): string
    {
        $spreadsheet_id = Spreadsheet::where('id', $spreadsheets_id)->value('spreadsheet_id');

        SlackMessage::checkColumnItems([$spreadsheet_id]);

        return $spreadsheet_id;
    }

        /**
     * 関連するシートのIDを取得する
     * @param int $spreadsheets_id SpreadsheetsテーブルのID
     * @param int $slack_users_id slack_usersテーブルのID
     * @return string $sheet_id スプレッドシートのシートID
     */
    public static function getSheetId(int $spreadsheets_id, int $slack_users_id): string
    {
        $sheet_id = Sheet::where('spreadsheets_id', $spreadsheets_id)->where('slack_users_id', $slack_users_id)->value('sheet_id');

        SlackMessage::checkColumnItems([$sheet_id]);

        return $sheet_id;
    }

    /**
     * slack_messagesリソースの登録を行う
     * @param int $slack_teams_id slack_teamsテーブルのID
     * @param int $slack_users_id slack_channelsテーブルのID
     * @param int $slack_channels_id slack_usersテーブルのID
     * @param string $message slackから送られてくるメッセージ
     * @return SlackMessage
     */
    public static function registerSlackPostsResources(int $slack_teams_id, int $slack_channels_id, int $slack_users_id, string $message): SlackMessage
    {
        return SlackMessage::Create([
            'slack_teams_id' => $slack_teams_id,
            'slack_channels_id' => $slack_channels_id,
            'slack_users_id' => $slack_users_id,
            'message' => $message
        ]);
    }

    /**
     * 取得したカラムの値のチェックを行う
     * @param array $columns チェック対象のデータ
     * @return void
     */
    public static function checkColumnItems($columns): void
    {
        if (in_array(NULL, $columns, true)) {
            $e = new Exception();
            throw $e;
        }
    }
}
