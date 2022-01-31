<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SlackChannel;
use App\Models\Spreadsheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    /**
     * slack_to_spreadsheetリソースの登録を行う
     * @param string $spreadsheet_id SpreadsheetsのID
     * @param string $slack_channel_id slack_channelのID
     * @param string $key_word 日報投稿のトリガーとなる文字列
     */
    public static function registerSlackToSpreadsheetResources(string $slack_channel_id, string $spreadsheet_id, string $key_word): void
    {
        $slack_channels_id = DB::table('slack_channels')->where('slack_channel_id', $slack_channel_id)->value('id');
        $spreadsheets_id = DB::table('spreadsheets')->where('spreadsheet_id', $spreadsheet_id)->value('id');

        SlackToSpreadsheet::firstOrCreate([
            'slack_channels_id' => $slack_channels_id,
            'spreadsheets_id' => $spreadsheets_id,
            'key_word' => $key_word
        ]);
    }
}
