<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Spreadsheet;
use App\Models\SlackUser;

class Sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'spreadsheets_id',
        'sheet_id',
        'slack_users_id',
    ];

    /**
     * spreadsheetsテーブルとの関連付けを行う
     * @return Spreadsheet Spreadsheetモデルを返す
     */
    public function spreadsheets()
    {
        return $this->belongsTo(Spreadsheet::class, 'spreadsheets_id');
    }

    /**
     * slack_usersテーブルとの関連付けを行う
     * @return SlackUser SlackUserモデルを返す
     */
    public function slackUsers()
    {
        return $this->belongsTo(SlackUser::class, 'slack_users_id');
    }
}
