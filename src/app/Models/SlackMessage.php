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
     * slack_messagesテーブルの登録に必要なデータをSlackMessageモデルにセットする
     * @param string $team_id slackのチームのID
     * @param string $user_id slackのチャンネルID
     * @param string $channel_id slackのユーザーID
     * @param string $message slackから送られてくるメッセージ
     * @return SlackMessage
     */
    public function setParam(string $team_id, string $user_id, string $channel_id, string $message): SlackMessage
    {
        $slack_team = SlackTeam::where('slack_team_id', $team_id)->first();

        $slack_users_id = $slack_team->slackUsers()->where('slack_user_id', $user_id)->value('id');
        $slack_channels_id = $slack_team->slackChannels()->where('slack_channel_id', $channel_id)->value('id');

        return $this->fill([
            'slack_teams_id' => $slack_team->id,
            'slack_users_id' => $slack_users_id,
            'slack_channels_id' => $slack_channels_id,
            'message' => $message
        ]);
    }
}
