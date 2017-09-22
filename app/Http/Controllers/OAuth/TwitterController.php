<?php

namespace App\Http\Controllers\OAuth;

use App\User;
use App\UserAuth;
use App\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Webpatser\Uuid\Uuid;

class TwitterController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        if ($request->has('denied')) {
            return redirect('login');
        }else{
            $user = Socialite::driver('twitter')->user();
            if ($user){
                $res = User::where('email', $user->email)->first();
                if ($res){
                    $user_auth = new UserAuth;
                    $user_auth->guid = $res->guid;
                    $user_auth->identity_type = 7;//from facebook
                    $user_auth->identity = 'facebook';//from facebook
                    $user_auth->certificate = $user->token;//access_token
                    $user_auth->save();
                    $res->nick_name = $user->name;
                    $res->gender = 0;
                    $res->face = $user->avatar;
                    $res->face200 = $user->avatar;
                    $res->faceSrc = $user->avatar_original;
                    $res->update();
                    Auth::attempt(['email'=>$user->email, 'password'=>'123456']);
                    return redirect('user-center');
                }else{//不存在用户
                    $guid = Uuid::generate();
                    $u = new User;
                    $u->guid = $guid;
                    $u->email = $user->email;
                    $u->password = bcrypt('123456');
                    $u->nick_name = $user->name;
                    $u->name = $user->name;
                    $u->gender = 0;
                    $u->face = $user->avatar;
                    $u->status = 1;//邮箱验证通过
                    $u->face200 = $user->avatar;
                    $u->faceSrc = $user->avatar_original;
                    $u->save();

                    $user_auth = new UserAuth;
                    $user_auth->guid = $u->guid;
                    $user_auth->identity_type = 8;//from facebook
                    $user_auth->identity = 'twitter';//from facebook
                    $user_auth->certificate = $user->token;//access_token
                    $user_auth->save();

                    $from_referral_code = session('FROM_REFERRAL_CODE');
                    $from_referral_id = '';
                    if ($from_referral_code){
                        $p = DB::table('points')->where('referral_code', $from_referral_code)->first();
                        if ($p){
                            $from_referral_id = $p->user_id;
                            DB::update('update points set points = points + ? where referral_code = ?',[10, session('FROM_REFERRAL_CODE')]);
                        }
                    }
                    $point = new Point;
                    $point->user_id = $u->id;
                    $point->guid = $u->guid;
                    $point->game_id = 1;
                    $point->game_id = 1;
                    $point->referral_code = $this->referralCode(1);
                    $point->from_referral_id = $from_referral_id;
                    $point->from_referral_code = $from_referral_code;
                    $point->points = 10;
                    $point->points_level = '1';
                    $point->save();
                    Auth::attempt(['email'=>$user->email, 'password'=>'123456']);
                    return redirect('user-center');
                }
            }else{
                return redirect('login');
            }
        }
    }
}