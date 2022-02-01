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

    /**
     * slack_teamsテーブルとの関連付けを行う
     * @return SlackTeam SlackTeamモデルを返す
     */
    public function slackTeam()
    {
        return $this->belongsTo(SlackTeam::class, 'slack_teams_id');
    }

    /**
     * sheetsテーブルとの関連付けを行う
     * @return Sheet Sheetモデルを返す
     */
    public function sheets()
    {
        return $this->hasMany(Sheet::class, 'slack_users_id');
    }
}
