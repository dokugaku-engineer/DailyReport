<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SlackTeam;
use App\Models\SlackChannel;
use App\Models\SlacUser;

class SlackMessage extends Model
{
    use HasFactory;

    /**
     * slack_to_spreadsheetリソースの登録を行う
     * @param string $spreadsheet_id SpreadsheetsのID
     * @param string $slack_channel_id slack_channelのID
     * @param string $key_word 日報投稿のトリガーとなる文字列
     */
    public static function registerSlackPostsResources(string $team_id, string $user_id, string $channel_id, string $message) 
    {



        // Slackの情報から各IDを抽出する
        $slack_teams_id = DB::table('slack_teams')->where('slack_team_id', $team_id)->value('id');
        $slack_channels_id = DB::table('slack_channels')->where('slack_channel_id', $channel_id)->where('slack_teams_id', $slack_teams_id)->value('id');
        $slack_users_id = DB::table('slack_users')->where('slack_user_id', $user_id)->where('slack_teams_id', $slack_teams_id)->value('id');

        // Spreadsheetの関連情報を取得する
        

        // Slack_to_spreadsheetの関連付けを確認する


        return SlackMessage::firstOrCreate([
            'slack_teams_id' => $slack_teams_id,
            'slack_channels_id' => $slack_channels_id,
            'slack_users_id' => $slack_users_id,
            'message' => $message
        ]);
    }

}
