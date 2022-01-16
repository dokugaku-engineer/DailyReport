<?php

namespace App\Http\Controllers;

use App\Models\Spreadsheet;
use Illuminate\Http\Request;

class SlackPostsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //SlackEventAPiから送られてくるチャレンジへの返答
        if ($request->input('type') == 'url_verification'){
            return response()->json($request->input('challenge'));
        }

        //SlackEventAPIから送られて来たメッセージJSONの内、使うものを取り出し

        //SlackEventAPIから送られてくるメッセージJSONのバリデーションチェック

        //SlackEventAPIから送られてくるメッセージをDBへ保存

        //メッセージをSpreadsheetに連携
        $spread_sheet = new Spreadsheet();

        // スプレッドシートに格納するテストデータです
        $insert_data = [
            'hoge' => 'test text',
            'huga' => 12345,
            'foo'  => true
        ];

        $spread_sheet->insert_spread_sheet($insert_data);

        return response('格納に成功！！', 200);       


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
