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
     * slack_teamsテーブルとの関連付けを行う
     * @return SlackTeam SlackTeamモデルを返す
     */
    public function slackTeam()
    {
        return $this->belongsTo(SlackTeam::class, 'slack_teams_id');
    }

    /**
     * slack_to_spreadsheetテーブルとの関連付けを行う
     * @return SlackToSpreadsheet SlackToSpreadsheetモデルを返す
     */
    public function slackToSpreadsheet()
    {
        return $this->hasMany(SlackToSpreadsheet::class, 'slack_channels_id');
    }
}
