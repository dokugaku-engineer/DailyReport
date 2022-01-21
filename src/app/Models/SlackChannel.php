<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\FalseType;

class SlackChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'slack_channel_id',
        'slack_teams_id'
    ];

    /**
     * Slack_teamsテーブルとの関連付けを行う
     * @return SlackTeam SlackTeamモデルを返す
     */
    public function slackTeam()
    {
        return $this->belongsTo(SlackTeam::class,'slack_teams_id');
    }

    /**
     * slack_channelテーブルにIDが登録されているか確認する
     * @param array $channel_ids Slackのchannel_idの配列
     * @return boolean 
     */   
    public function getChannelIdExistence($channel_ids)
    {
        //DBへ存在チェック処理を行う
        foreach($channel_ids as $channel_id){
            $result = $this->Where($channel_id)->exists();

            if($result==false){
                break;
            }
        }
        //結果を返す
        return $result;
    }

}
