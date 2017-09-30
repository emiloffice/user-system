<?php

namespace App\Http\Controllers\OAuth;

use App\Point;
use App\UserAuth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if ($request->has('error')) {

        }else{


            $user = Socialite::driver('facebook')->user();
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
                    $user->user['gender'] =='male' ? $res->gender = 1 : $res->gender = 2;
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
                    $user->user['gender'] =='male' ? $u->gender = 1 : $u->gender = 2;
                    $u->face = $user->avatar;
                    $u->status = 1;//邮箱验证通过
                    $u->face200 = $user->avatar;
                    $u->faceSrc = $user->avatar_original;
                    $u->save();

                    $user_auth = new UserAuth;
                    $user_auth->guid = $u->guid;
                    $user_auth->identity_type = 7;//from facebook
                    $user_auth->identity = 'facebook';//from facebook
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
                    if ($user->email!==''){
                        Auth::attempt(['email'=>$user->email, 'password'=>'123456']);
                        return redirect('user-center');
                    }else{
                        session(['OAUTH_INFO'=>$u]);
                        return redirect('oauth-confirm-email');
                    }

                }
            }else{
                return redirect('login');
            }
        }
    }

    public function getAccessToken(Request $request)
    {
        dd($request);
    }
    /*
 * @param int $no_of_codes//定义一个int类型的参数 用来确定生成多少个优惠码
 * @param array $exclude_codes_array//定义一个exclude_codes_array类型的数组
 * @param init $code_length //定义一个code_length的参数来确定优惠码的长度
 * @return array//返回数组
 * */
    public function referralCode($no_of_codes, $exclude_codes_array='', $code_length = 6)
    {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $promotion_codes = array();//这个数组用来接收生成的优惠码
        for ($j = 0; $j < $no_of_codes; $j++){
            $code = "";
            for ($i = 0; $i < $code_length; $i++){
                $code .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
            //如果生成的6位随机数不在我们定义的$promotion_codes函数里
            if (!in_array($code, $promotion_codes)){
                if (is_array($exclude_codes_array)){
                    if (!in_array($code, $exclude_codes_array)){//排除已经使用的优惠码数
                        $promotion_codes[$j] = $code;//将新生成的优惠码赋值给promotion_codes数组
                    }else{
                        $j--;
                    }
                }else {
                    $promotion_codes[$j] = $code;//将优惠码赋值给数组
                }
            }else{
                $j--;
            }
        }
        if ($no_of_codes = 1){
            $promotion_codes = $promotion_codes[0];
        }
        return $promotion_codes;
    }
}
