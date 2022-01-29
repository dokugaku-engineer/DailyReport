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
     * @param mixed $spreadsheet_id SpreadsheetsのID
     * @param mixed $slack_channel_id slack_channelのID
     * @param mixed $key_word 日報投稿のトリガーとなる文字列
     */
    public static function registerSlackToSpreadsheetResources($spreadsheet_id, $slack_channel_id, $key_word): void
    {
        DB::beginTransaction();

        try {
            //slack_channelsテーブルからIDを取得
            $slack_channels = new SlackChannel(['slack_channel_id', $slack_channel_id]);
            $slack_channels_id= $slack_channels->value('id');
            //spreadsheetsテーブルからIDを取得
            $spreadsheets = new Spreadsheet(['spreadsheet_id', $spreadsheet_id]);
            $spreadsheets_id= $spreadsheets->value('id');
            dd($spreadsheets_id);
            //DB保存
            $saved_slack_to_spreadsheet = SlackToSpreadsheet::firstOrCreate([
                'slack_channels_id' => $slack_channels_id,
                'spreadsheets_id' => $spreadsheets_id,
                'key_word' => $key_word
            ]);
        } catch (Exception $e) {

            DB::rollBack();

            $response = response()->json([
                'status' => 500,
                'error' => 'DataBase Error',
            ], 500);

            throw new HttpResponseException($response);
        }
        DB::commit();
    }
}
