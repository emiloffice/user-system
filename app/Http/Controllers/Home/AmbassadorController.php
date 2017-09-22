<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Point;
use Illuminate\Support\Facades\DB;

class AmbassadorController extends Controller
{
    public function index()
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $user = Auth::user();
        if ($user === ''){
            $user = null;
        }
        $points = Point::where('status','1')->orderBy('points','desc')->take(10)
            ->join('users', 'points.user_id', '=', 'users.id')
            ->get();
        if($this->is_mobile_request()){
            return view('mobile.ambassador', compact('points','user','HTTPS_REQUEST'));
        }else{
            return view('home.ambassador', compact('points','user','HTTPS_REQUEST'));
        }
        return view('home.ambassador');
    }
    public function center()
    {
        $HTTPS_REQUEST = env('HTTPS_REQUEST');
        $user = Auth::user();
        $user_id = $user->id;
        $game_id = 1;//默认为seekingdawnid
        $point = DB::table('points')->where(['user_id'=>$user_id,'game_id'=>$game_id])->first();
        $res = $this->ambassador_level($point->points);
        $point->level = $res['level'];
        $point->progress = $res['progress'];
        $ranks = DB::table('points')->where([])->orderBy('points','esc')->get();
        $rank = '';
        for ($i=0;$i<count($ranks);$i++) {
            if ($ranks[$i]->user_id == $user_id){
                $rank =  $i+1;
            }
        }
        if ($point->referral_code){
            $friends = Point::where('from_referral_code',$point->referral_code)
                ->join('users', 'points.user_id', '=', 'users.id')
                ->get();
        }else{
            $friends = '';
        }
        if ($this->is_mobile_request()){
            return view('mobile.uc', compact('user','point','friends','HTTPS_REQUEST', 'rank'));
        } else{
            return view('home.uc', compact('user','point','friends','HTTPS_REQUEST','rank'));
        }
    }
    // 积分进度条
    /*
     * $points
     * */
    public function ambassador_level($points){
        $res = '';
        if (0<= $points && $points < 100){
            $res['level'] = 1;
            $res['progress'] = (round(($points)/100 ,2))*100;
        } else if(100<= $points && $points < 200){
            $res['level'] = 2;
            $res['progress'] = (round(($points-100)/100 ,2))*100;
        } else if(200<= $points && $points < 300){
            $res['level'] = 3;
            $res['progress'] = (round(($points-200)/100 ,2))*100;
        } else if(300<= $points && $points < 400){
            $res['level'] = 4;
            $res['progress'] = (round(($points-300)/100 ,2))*100;
        } else if(400<= $points && $points < 500){
            $res['level'] = 5;
            $res['progress'] = (round(($points-400)/100 ,2))*100;
        } else if(500<= $points && $points < 700){
            $res['level'] = 6;
            $res['progress'] = (round(($points-500)/200 ,2))*100;
        } else if(700<= $points && $points < 800){
            $res['level'] = 7;
            $res['progress'] = (round(($points-700)/100 ,2))*100;
        } else if(800<= $points){
            $res['level'] = '8 (Ultimate Pirize)';
            $res['progress'] = '100';
        }
        return $res;

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
