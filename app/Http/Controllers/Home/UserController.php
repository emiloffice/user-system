<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
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
}
