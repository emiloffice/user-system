<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('api');
    }
   //调用认证接口获取授权码
    public function login(Request $request)
    {
        $credentials = $this->credentials($request);

        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        return \Response::json([
            'status' => "error",
            'message' => "用户名或密码有误"
        ], 401);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request);
    }

    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    protected function authenticateClient(Request $request)
    {
        $data = $request->all();
        if ($request->refresh_token) {
            $request->request->add([
                'grant_type' => $data['grant_type'],
                'client_id' => $data['client_id'],
                'client_secret' => $data['client_secret'],
                'refresh_token' => $data['refresh_token'],
                'scope' => ''
            ]);
        } else {
            $request->request->add([
                'grant_type' => $data['grant_type'],
                'client_id' => $data['client_id'],
                'client_secret' => $data['client_secret'],
                'username' => $data['staffid'],
                'password' => $data['password'],
                'scope' => ''
            ]);
        }

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);
        $token = json_decode($response->getContent());
        $token->user = $request->user();

        return response()->json($token);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'staffid';
    }

}
