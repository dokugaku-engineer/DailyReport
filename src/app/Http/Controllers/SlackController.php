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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team_id = $request->input('team_id');
        $channels = $request->input('channels');
        $users = $request->input('users');

        $MAE = new MultidimensionalArrayEditor;
        $channel_ids = $MAE->createNewArray($channels,'channel_id','slack_channel_id');
        $user_ids = $MAE->createNewArray($users,'user_id','slack_user_id');
        
        $slack_team_model = new SlackTeam;
        $slack_channel_model = new SlackChannel;
        $slack_user_model = new SlackUser;

        $team_id_record_existence = $slack_team_model->getTeamIdExistence($team_id);
        $channel_id_record_existence = $slack_channel_model->getChannelIdExistence($channel_ids);
        $user_id_record_existence = $slack_user_model->getUserIdExistence($user_ids);
        
        if($team_id_record_existence&&$channel_id_record_existence&&$user_id_record_existence)
        {
            $exception = new Exception("Record_Existence",400);
            throw $exception;
        }
        
        DB::beginTransaction();
        
        try{
            $result_of_save_record = $slack_team_model->create([
                'slack_team_id' => $team_id 
            ]);
            
            foreach($channel_ids as $channel_id){
                $result_of_save_record->associateSlackChannels()->create($channel_id);
            }
            
            foreach($user_ids as $user_id){
                $result_of_save_record->associateSlackUsers()->create($user_id);
            }

        }catch(Exception $e){ 
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return response()->json_content('201','Resource_Created');
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
