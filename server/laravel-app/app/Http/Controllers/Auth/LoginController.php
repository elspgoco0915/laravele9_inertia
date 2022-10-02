<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToProvider(Request $request) {

        $provider = $request->provider;
        return Socialite::driver($provider)->redirect();

    }

    public function handleProviderCallback(Request $request) {

        $provider = $request->provider;
        $social_user = Socialite::driver($provider)->user();
        $social_email = $social_user->getEmail();
        $social_name = $social_user->getName();

        if(!is_null($social_email)) {

            $user = User::firstOrCreate([
                'email' => $social_email
            ], [
                'email' => $social_email,
                'name' => $social_name,
                'password' => Hash::make(Str::random())
            ]);

            auth()->login($user);
            return redirect('/dashboard');

        }

        return '必要な情報が取得できていません。';

    }
}
