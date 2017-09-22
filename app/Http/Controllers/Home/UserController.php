<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Postmark\PostmarkClient;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'email' => 'required|exists:users,email',
                'password' => 'required|min:6|max:30'
            ]);
            if ($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }else{
                if (Auth::attempt(['email' => $request->email, 'password'=> $request->password])){
                    $user = Auth::user();
                    if($user->status=='0'){
                        session(['CONFIRM_EMAIL'=>$user->email]);
                        return redirect('confirm-email');
                    }else{
                        return redirect('user-center');
                    }
                }else{
                    $res = 'Email or password is wrong';
                    if ($this->is_mobile_request()){
                        return view('mobile.login', compact('HTTPS_REQUEST','res'));
                    } else {
                        return view('home.login', compact('HTTPS_REQUEST','res'));
                    }
                }
            }
        }else{
            if ($this->is_mobile_request()){
                return view('mobile.login', compact('HTTPS_REQUEST'));
            } else {
                return view('home.login', compact('HTTPS_REQUEST'));
            }
        }
    }
    public function register(Request $request)
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        if ($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users',
                'username' => 'required|max:50|min:4',
                'password' => 'required|min:6|max:30'
            ]);
            if ($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }else{
                $email = $request->email;
                $res = DB::table('users')->where('email',$email)->first();
                if($res){
                    $validator->errors()->add('email', 'The email has been registered!');
                    return Redirect::back()->withErrors($validator)->withInput();
                }else{
                    $User = new User;
                    $User->name = $request->username;
                    $User->password = bcrypt($request->password);
                    Session(['USER_PWD'=>$request->password]);
                    $User->email = $email;
                    $User->save();
                    session(['USER_INFO'=>$User]);
                    $Point = new Point;
                    $Point->user_id = $User->id;
                    $from_referral_id = Point::where('referral_code', $request->referral_code)->value('user_id');
                    $Point->from_referral_code = $request->referral_code;//提交的推荐码
                    $Point->from_referral_id = $from_referral_id;//提交的推荐人ID
                    $Point->referral_code = $this->referralCode(1);//生成的自己的推荐码数
                    $Point->game_id = '1';//默认seekingdawn为1
                    $Point->points = 0;//默认seekingdawn为1
                    $Point->points_level = 1;//初始等级为1
                    $Point->save();
                    return redirect('confirm-email');
                }
            }

        }
        if ($request->isMethod('get')){
            $code = $request->code;
            if ($this->is_mobile_request()){
                return view('mobile.register', compact('code','HTTPS_REQUEST'));
            } else {
                return view('home.register', compact('code','HTTPS_REQUEST'));
            }
        }
    }
    public function is_mobile_request()
    {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser      = '0';
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        $mobile_ua     = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
        );
        if (in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        // Pre-final check to reset everything if the user is on Windows
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser = 0;
        // But WP7 is also Windows, with a slightly different characteristic
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        if ($mobile_browser > 0)
            return true;
        else
            return false;
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
    /*
     *
     * */
    public function confirmEmail(Request $request)
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $email = session('CONFIRM_EMAIL');
        if ($email){
            return view('home.confirmEmail',compact('email','HTTPS_REQUEST'));
        }else{
            $user = session('USER_INFO');
            if($user->email!==''||$user->email!==null){
                $email = $user->email;
                return view('home.confirmEmail',compact('email','HTTPS_REQUEST'));
            }
            else {
                return view('home.confirmEmail',compact('HTTPS_REQUEST'));
            }
        }
    }
    public function OAuthConfirmEmail()
    {
        $user = session('OAUTH_INFO');
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $token = $user->token;
        $email = $user->email;
        $res = DB::table('users')->where('oauth_token', $token)->orWhere('email', $email)->first();

        if ($res){
            Auth::attempt(['email'=>$res->email, 'password' => '123456']);
            return redirect('user-center');
        }else{
            if($user->email!==''||$user->email!==null){
                $email = $user->email;
                return view('home.OauthConfirmEmail',compact('email','HTTPS_REQUEST'));
            }
            else {
                return view('home.OauthConfirmEmail', compact('HTTPS_REQUEST'));
            }
        }

    }
    public function sendConfirmEmail(Request $request)
    {
        $client = new PostmarkClient('dd3a9434-fae6-4fe4-a67c-e3579d36c637');
        // Send an email:
        $code = $this->referralCode('1','','6');
        session(['EMAIL_CONFIRM_CODE'=>$code]);
        $sendResult = $client->sendEmail(
            "emil@multiverseinc.com",
            $request->email,
            $code.", Verification code from Multiverse Entertainment LLC ",
            "Hello, This is your sign up verification code：".$code
        );
        return json_encode($sendResult);
    }
    public function OauthVerifyUserEmail(Request $request)
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $code = session('EMAIL_CONFIRM_CODE');
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'code' => 'required|min:4|max:6',
        ]);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            if ($code === $request->code){
                $user = session('OAUTH_INFO');
                $email = $user->email = $request->email;
                $this->createUser($user,'twitter');
                Point::where('referral_code',$request->referral_code)->increment('points', 10);
                Auth::attempt(['email' => $email, 'password' => '123456']);
                return redirect('user-center');
            }else{
                return Redirect::back()->withInput()->with('codeError','The Verification code you entered is incorrect ！');

            }
        }
    }
    public function defaultVerifyUserEmail(Request $request)
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $code = session('EMAIL_CONFIRM_CODE');
        $validator = Validator::make($request->all(),[
            'code' => 'required|min:4|max:6',
        ]);
        if ($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
        }else{
            if ($code === $request->code){
                $email = $request->email;
                $user = DB::table('users')->where('email',$email)->get();
                if ($user[0]!==''||$user[0]!==null){
                    $user_id = $user[0]->id;
                    DB::update('update points set points = ? where user_id = ?',[10, $user_id]);
                    DB::update('update users set status = ? where id = ?',[1, $user_id]);
                    if (DB::table('points')->where('referral_code', session('FROM_REFERRAL_CODE'))->first()){
                        DB::update('update points set points = points + ? where referral_code = ?',[10, session('FROM_REFERRAL_CODE')]);
                    }
                    Auth::attempt(['email'=>$email, 'password'=> session('USER_PWD')]);
                    return redirect('user-center');
                }
                return redirect('confirm-email');
            }else{
                $validator->errors()->add('code', 'The Verification code you entered is incorrect ！');
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }
    }
}
