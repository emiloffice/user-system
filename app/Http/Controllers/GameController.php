<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Ramsey\Uuid\Uuid;
use App\GameUpdateProject;
class GameController extends Controller
{
    public function updateCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'game_name'=> 'required',
            'game_version'=> 'required',
            'game_update_at'=> 'required',
            'game_content'=> 'required',
        ]);
        if ($validator->fails()){
            return $validator->errors();
        }
        $game_update_project = new GameUpdateProject();
        $game_update_project->game_gid = Uuid::generate();
        $game_update_project->game_name = $request->game_name;
        $game_update_project->game_version = $request->game_version;
        $game_update_project->game_update_at = $request->game_update_at;
        $game_update_project->update_content = $request->update_content;
        $game_update_project->save();
        return json_encode($game_update_project);
    }
}
