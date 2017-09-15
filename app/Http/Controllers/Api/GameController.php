<?php

namespace App\Http\Controllers\Api;

use App\GameUpdateProject;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index()
    {
        return 'index';
    }

    public function update_at(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'game_gid'=> 'required',
        ]);
        if ($validator->fails()){
            return $validator->errors();
        }
        $res = GameUpdateProject::where('game_gid',$request->game_gid)->first();
        if ($res){
            $res->timestamp = strtotime($res->game_update_at);
            $res->now = strtotime(now());
            return json_encode($res);
        }
        $friday = date('Y-m-d',strtotime('Friday')).' 20:00:00';
        $timestamp = strtotime($friday);
        $now = strtotime(now());
        return json_encode(['timestamp'=>$timestamp, 'now'=>$now]);
    }
}
