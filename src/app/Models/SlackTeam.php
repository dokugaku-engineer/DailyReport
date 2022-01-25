<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SlackChannel;
use App\Models\SlackUser;
use Illuminate\Http\Request;

class SlackTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'slack_team_id'
    ];

    /**
     * Slack_Channelsテーブルとの関連付けを行う
     * @return SlackChannel SlackChannelモデルを返す
     */

    public function associateSlackChannels()
    {
        return $this->hasMany(SlackChannel::class, 'slack_teams_id');
    }

    /**
     * Slack_Usersテーブルとの関連付けを行う
     * @return SlackUser SlackUserモデルを返す
     */
    public function associateSlackUsers()
    {
        return $this->hasMany(SlackUser::class, 'slack_teams_id');
    }

    /**
     * Slackリソースの登録を行う
     * @param mixed $team_id SlackのチームID
     * @param mixed $channel_id SlackのチャンネルID
     * @param mixed $user_id SlackのユーザーID
     */
    public static function registerSlackResources($team_id, $channel_id, $user_id): void
    {
        $saved_slack_team = SlackTeam::create(['slack_team_id' => $team_id]);
        $saved_slack_team->associateSlackChannels()->create(['slack_channel_id' => $channel_id]);
        $saved_slack_team->associateSlackUsers()->create(['slack_user_id' => $user_id]);
    }
}
