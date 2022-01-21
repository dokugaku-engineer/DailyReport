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
        return $this->hasMany(SlackChannel::class,'slack_teams_id');
    }

    /**
     * Slack_Usersテーブルとの関連付けを行う
     * @return SlackUser SlackUserモデルを返す
     */
    public function associateSlackUsers()
    {
        return $this->hasMany(SlackUser::class,'slack_teams_id');
    }

    /**
     * Slack_TeamsテーブルにIDが登録されているか確認する
     * @param mixed $team_id Slackのteam_id
     * @return boolean 
     */
    public function getTeamIdExistence($team_id)
    {
        //DBへ存在チェック処理を行う
        $result = $this -> where('slack_team_id',$team_id)->exists();

        //結果を返す
        return $result;
    }
}

