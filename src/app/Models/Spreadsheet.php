<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sheet;
use App\Models\SlackUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class Spreadsheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'spreadsheet_id'
    ];

    /**
     * sheetsテーブルとの関連付けを行う
     * @return Sheet Sheetモデルを返す
     */
    public function sheets()
    {
        return $this->hasMany(Sheet::class, 'spreadsheets_id');
    }

    /**
     * slack_to_spreadsheetテーブルとの関連付けを行う
     * @return SlackToSpreadsheet SlackToSpreadsheetモデルを返す
     */
    public function slackToSpreadsheets()
    {
        return $this->hasMany(SlackToSpreadsheet::class, 'spreadsheets_id');
    }

    /**
     * Spreadsheetリソースの登録を行う
     * @param string $spreadsheet_id スプレッドシートID
     * @param string $sheet_id スプレッドシートのシートID
     * @param string $slack_user_id slack_usersテーブルのID
     */
    public static function registerSpreadsheetResources(string $spreadsheet_id, string $sheet_id, string $slack_user_id): void
    {
        DB::beginTransaction();

        try {
            $slack_user = new SlackUser(['slack_user_id', $slack_user_id]);
            $slack_users_id = $slack_user->value('id');
            $saved_spreadsheet = Spreadsheet::firstOrCreate(['spreadsheet_id' => $spreadsheet_id]);
            $saved_spreadsheet->sheets()->firstOrCreate(['sheet_id' => $sheet_id, 'slack_users_id' => $slack_users_id]);
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
