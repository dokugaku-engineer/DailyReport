<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\FalseType;
use App\Models\SlackTeam;

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
        return $this->belongsTo(SlackTeam::class, 'slack_teams_id');
    }
}
