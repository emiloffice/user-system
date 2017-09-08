<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }
    public function info(){
        return json_encode(['status'=>'success','user'=>'1']);
    }

    public function captcha(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                echo '<p style="color: #ff0000;">Incorrect!</p>';
            }
            else
            {
                echo '<p style="color: #00ff30;">Matched :)</p>';
            }
        }

        $form = '<form method="post" action="captcha-test">';
        $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $form .= '<p>\' . captcha_img() . \'</p>\'';
        $form .= '<p><input type="text" name="captcha"></p>';
        $form .= '<p><button type="submit" name="check">Check</button></p>';
        $form .= '</form>';
        return $form;
    }
}
