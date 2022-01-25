<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlackTeam;
use App\Models\SlackChannel;
use App\Models\SlackUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Services\MultidimensionalArrayEditor;

class SlackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @bodyParam string[] ["team_id" => "a4rtrdt", "channel_id" => "ad46dr5", "user_id" => "Ude4643d"]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'team_id' => 'required|unique:slack_teams,slack_team_id|string',
            'channel_id' => 'required|unique:slack_channels,slack_channel_id|string',
            'user_id' => 'required|unique:slack_users,slack_user_id|string'
        ]);

        DB::beginTransaction();

        try {
            SlackTeam::registerSlackResources($validated['team_id'], $validated['channel_id'], $validated['user_id']);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return response()->json_content('201', 'Resource_Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
