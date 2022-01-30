<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlackTeam;
use App\Models\SlackChannel;
use App\Models\SlackUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SlackRequest;
use Illuminate\Support\Facades\Validator;

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
     * @param  \App\Http\Requests\SlackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlackRequest $request)
    {
        $validated = $request->validated();

        SlackTeam::registerSlackResources($validated['team_id'], $validated['channel_id'], $validated['user_id']);

        return response()->json_content(201, 'Resource_Created', 201);
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
