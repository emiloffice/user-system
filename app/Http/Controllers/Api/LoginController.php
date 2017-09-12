<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class LoginController extends ApiController
{
    public function username()
    {
        return "email";
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            /*'username'    => 'required|exists:users',
            'password' => 'required|between:6,32',*/
        ]);
        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code'   => 401,
            ]);
            return $this->sendFailedLoginResponse($request);
        }
        $credentials = $this->credentials($request);
        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

//        return $this->failure('login failed',401);
        return response()->json(['login failed'=>401]);
    }
}
