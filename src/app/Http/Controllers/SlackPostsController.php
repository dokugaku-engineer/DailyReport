<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SlackMessage;
use App\Services\PostSpreadsheet;
use Exception;

//use App\Models\Spreadsheet;

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
        $slack_team_id = $request->input('team_id');
        $slack_channel_id = $request->input('event.channel');
        $slack_user_id = $request->input('event.user');
        $message = $request->input('event.text');
       
        //dd(!$slack_team_id);
        //SlackEventAPIから送られてくるメッセージJSONのバリデーションチェック
        if(!$slack_channel_id || !$slack_team_id || !$message || !$slack_user_id){
            throw new Exception('',400);
            //return response()->json_content('400','Bad_REQUEST');
        }     

        //日報として格納する投稿かチェック（キーワードがあるか）
        //key_wordの値を取得して正規表現trueかどうか



        //SlackEventAPIから送られてくるメッセージをDBへ保存
        //SlackMessageモデルのインスタンスを生成
        $slack_message_model = new SlackMessage;
        //DBへデータを保存
        $slack_message_model->slack_team_id = $slack_team_id;
        $slack_message_model->slack_channel_id = $slack_channel_id;
        $slack_message_model->slack_user_id = $slack_user_id;
        $slack_message_model->message = $message;
        
        $slack_message_model->save();



        //メッセージをSpreadsheetに連携
        $spread_sheet = new PostSpreadsheet();

        // スプレッドシートに格納するテストデータです
        $insert_data = [
            'slack_team_id' => $slack_team_id,
            'slack_channel_id' => $slack_channel_id,
            'slack_user_id'  => $slack_user_id,
            'message'  => $message
        ];

        $spread_sheet->insertSpreadsheet($insert_data);

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
