<?php

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

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
            session(['OAUTH_INFO'=>$user]);
            print_r($user);
//            return redirect('oauth-confirm-email');
        }
    }
}