<?php

namespace App\Http\Controllers\OAuth;

use App\UserAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Webpatser\Uuid\Uuid;

class FbController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback(Request $request)
    {
            $user = Socialite::driver('facebook')->user();
            if ($user){
                $res = User::where('email', $user->email)->first();
                if ($res){
                    $user_auth = new UserAuth;
                    $user_auth->guid = $res->guid;
                    $user_auth->identity_type = 7;//from facebook
                    $user_auth->identity = 'facebook';//from facebook
                    $user_auth->certificate = $user->token;//access_token
                    $user_auth-save();
                    $res->nick_name = $user->name;
                    $user->gender=='male' ? $res->gender = 1 : $res->gender = 2;
                    $res->face = $user->avatar;
                    $res->face200 = $user->avatar;
                    $res->faceSrc = $user->avatar_original;
                    $res->update();
                    Auth::attempt(['email'=>$user->email, 'password'=>'123456']);
                    return redirect('user-center');
                }else{
                    $guid = Uuid::generate();
                    $u = new User;
                    $u->guid = $guid;
                    $u->email = $user->email;
                    $u->password = bcrypt('123456');
                    $u->nick_name = $user->name;
                    $user->user['gender'] =='male' ? $u->gender = 1 : $u->gender = 2;
                    $u->face = $user->avatar;
                    $u->face200 = $user->avatar;
                    $u->faceSrc = $user->avatar_original;
                    $u->save();
                    if ($u){
                        $user_auth = new UserAuth;
                        $user_auth->guid = $u->guid;
                        $user_auth->identity_type = 7;//from facebook
                        $user_auth->identity = 'facebook';//from facebook
                        $user_auth->certificate = $user->token;//access_token
                        $user_auth->save();
                        Auth::attempt(['email'=>$user->email, 'password'=>'123456']);
                        return redirect('user-center');
                    }


                }
            }else{
                return redirect('login');
            }
    }

    public function getAccessToken(Request $request)
    {
        dd($request);
    }
}
