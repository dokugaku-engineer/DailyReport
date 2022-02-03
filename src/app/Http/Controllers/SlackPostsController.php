<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SlackMessage;
use App\Services\SpreadsheetApi;
use Exception;
use MessageFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SlackPostsRequest;


class SlackPostsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlackPostsRequest $request)
    {
        $validated = $request->validated();

        $check_result = SlackPostsRequest::checkChallengeRequest($validated);
        if ($check_result == true) {
            return response()->json(["challenge" => $validated['challenge']]);
        }

        $slack_messages_column = SlackMessage::readySlackPostsResources($validated['team_id'], $validated['event']['user'], $validated['event']['channel'], $validated['event']['text']);
        $slack_to_spreadsheet_column = SlackMessage::getSlackToSpreadsheetInfo($slack_messages_column['slack_channels_id']);

        SlackMessage::checkKeyWord($slack_to_spreadsheet_column['key_word'], $slack_messages_column['message']);

        $spreadsheet_id = SlackMessage::getSpreadsheetId($slack_to_spreadsheet_column['spreadsheets_id']);
        $sheet_id = SlackMessage::getSheetId($slack_to_spreadsheet_column['spreadsheets_id'], $slack_messages_column['slack_users_id']);

        DB::beginTransaction();

        $save_slack_messages = SlackMessage::registerSlackPostsResources(
            $slack_messages_column['slack_teams_id'],
            $slack_messages_column['slack_channels_id'],
            $slack_messages_column['slack_users_id'],
            $slack_messages_column['message']
        );

        $spreadsheet_client = new SpreadsheetApi();

        $result = $spreadsheet_client->insertSpreadsheet($slack_messages_column['message'], $spreadsheet_id, $sheet_id);

        if ($result == false) {
            DB::rollBack();

            $e = new Exception();
            throw  $e;
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
