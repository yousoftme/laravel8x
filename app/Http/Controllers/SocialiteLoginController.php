<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends Controller
{
    public function githubLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        $db_user = User::where(['email' => $user->getEmail()])->first();
        if($db_user){
            Auth::login($db_user);
            return redirect()->route('dashboard');
        }else{
            $db_user = User::create([
                'name' => $user->getName(),
                'username' => $user->getNickname(),
                'email' => $user->getEmail(),
                'avatar'         => $user->getAvatar(),
                'provider_id'   => $user->getId(),
                'provider'      => 'github',
            ]);
            Auth::login($db_user);
            return redirect()->route('dashboard');        
        }
    }
}
