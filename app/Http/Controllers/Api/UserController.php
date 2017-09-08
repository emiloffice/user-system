<?php

namespace App\Http\Controllers\Api;

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

}
