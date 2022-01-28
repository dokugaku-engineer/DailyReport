<?php

namespace App\Models;

use Google\Service\Sheets\Spreadsheet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlackToSpreadsheet extends Model
{
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'slack_to_spreadsheet';

    protected $fillable = [
        'slack_channels_id',
        'spreadsheets_id',
        'key_word'
    ];

    /**
     * slack_channelsテーブルとの関連付けを行う
     * @return SlackChannel SlackChannelモデルを返す
     */
    public function slackChannel()
    {
        return $this->belongsTo(SlackChannel::class, 'slack_channels_id');
    }

    /**
     * spreadsheetsテーブルとの関連付けを行う
     * @return Spreadsheet Spreadsheetモデルを返す
     */
    public function spreadsheet()
    {
        return $this->belongsTo(Spreadsheet::class, 'spreadsheets_id');
    }
}
