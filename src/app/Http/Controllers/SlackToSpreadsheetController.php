<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlackChannel;
use App\Models\Spreadsheet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SlackToSpreadsheetRequest;
use App\Models\SlackToSpreadsheet;
use Illuminate\Support\Facades\Validator;

class SlackToSpreadsheetController extends Controller
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
     *
     * @param  \App\Http\Requests\SlackToSpreadsheetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlackToSpreadsheetRequest $request)
    {
        $validated = $request->validated();

        SlackToSpreadsheet::registerSlackToSpreadsheetResources(
            $validated['slack_channel_id'],
            $validated['spreadsheet_id'],
            $validated['key_word']
        );

        return response()->json_content('201', 'Resource_Created', 201);
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
