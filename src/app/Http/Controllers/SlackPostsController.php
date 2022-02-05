<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SpreadsheetApi;
use Exception;
use MessageFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SlackPostsRequest;
use App\Models\SlackToSpreadsheet;
use App\Models\Spreadsheet;
use App\Models\Sheet;
use App\Models\SlackMessage;

class SlackPostsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlackPostsRequest $request)
    {
        $validated = $request->validated();

        // SlackEventAPI経由でメッセージを連携する際、まず「チャレンジリクエスト」が送られるため、このレスポンスを行い連携先の正常性を証明します。
        if ($validated['type'] == 'url_verification') {
            return response()->json(["challenge" => $validated['challenge']]);
        }

        $slack_message = new SlackMessage();
        $slack_message->setParam($validated['team_id'], $validated['event']['user'], $validated['event']['channel'], $validated['event']['text']);

        DB::beginTransaction();

        try {
            $slack_message->save();
            $slack_to_spreadsheet = SlackToSpreadsheet::where('slack_channels_id', $slack_message->slack_channels_id)->first();
            $spreadsheet_id = Spreadsheet::where('id', $slack_to_spreadsheet->spreadsheets_id)->value('spreadsheet_id');
            $sheet_id = Sheet::where([['spreadsheets_id', '=', $slack_to_spreadsheet->spreadsheets_id], ['slack_users_id', '=', $slack_message->slack_users_id]])->value('sheet_id');
            $spreadsheet = new SpreadsheetApi($spreadsheet_id, $sheet_id);
            $spreadsheet->insertSpreadsheet($slack_message->message);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return response()->json_content(201, 'Resource_Created', 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
