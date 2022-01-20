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

    public function slackTeam()
    {
        return $this->belongsTo(SlackTeam::class,'slack_teams_id');
    }

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
