<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleLoginController extends Controller
{


public function redirect()
{
    $redirectUri = config('services.google.redirect');

    return Socialite::driver('google')->stateless()->redirect();
}


    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->id)
                    ->orWhere('email', $googleUser->email)
                    ->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(str()->random(16)),
            ]);
        } elseif (!$user->google_id) {
            $user->update(['google_id' => $googleUser->id]);
        }

        Auth::login($user);

        return redirect()->route('profile.edit')->with('status', 'Please complete your profile to appear in search results.');
    }
    
}
