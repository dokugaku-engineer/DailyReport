<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlackUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'slack_user_id',
        'slack_teams_id'
    ];

    public function slackTeam()
    {
        return $this->belongsTo(SlackTeam::class,'slack_teams_id');
    }

    public function getUserIdExistence($user_ids)
    {
        //DBへ存在チェック処理を行う
        foreach($user_ids as $user_id){
            $result = $this->Where($user_id)->exists();

            if($result==false){
                break;
            }
        }
        //結果を返す
        return $result;
    }   
}
