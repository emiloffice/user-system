<?php

namespace App\Http\Controllers\Api;

use App\Feedback;
use App\Http\Controllers\ApiController;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class UserController extends Controller
{
    use AuthenticatesUsers;
    public function info(Request $request)
    {
        return $request->user();
    }

    public function feedback(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:100',
            'contents' => 'required|max:500'
        ]);
        if ($validator->fails()){
            return $validator->errors();
        }
        $feedback = new Feedback();
        $feedback->title = $request->title;
        $feedback->contents = $request->contents;
        $feedback->uid = $user->id;
        $feedback->guid = $user->guid;
        $feedback->from_type = '1';
        $feedback->from_type_id = '1';
        $feedback->from_type_name = 'Seeking Dawn';
        $feedback->save();
        return $feedback;
    }
}  
