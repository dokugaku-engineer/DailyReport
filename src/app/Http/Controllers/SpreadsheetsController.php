<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spreadsheet;
use App\Models\Sheet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\SpreadsheetsRequest;
use Illuminate\Support\Facades\Validator;

class SpreadsheetsController extends Controller
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
     * @bodyParam string[] ["spreadsheet_id" => "a4rtrdt", "sheet_id" => "ad46dr5", "slack_user_id" => "Ude4643d"]
     * @param  \App\Http\Requests\SpreadsheetsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpreadsheetsRequest $request)
    {
        $validated = $request->validated();

        Spreadsheet::registerSpreadsheetResources($validated['spreadsheet_id'], $validated['sheet_id'], $validated['slack_user_id']);

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
