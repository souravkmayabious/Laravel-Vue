<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    public function loadLogins(){
        return view('auth.social.login');
    }

    public function redirectToProvider($provider)
    {
        // Check if the provider is supported
        if (!in_array($provider, ['github', 'google', 'facebook', 'twitter', 'linkedin'])) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        // Redirect to the provider's OAuth page
        return Socialite::driver($provider)->redirect();
    }

    // Handle the callback from the social provider
    public function handleProviderCallback($provider)
    {
        try {
            // Get the user's information from the provider
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong, please try again.');
        }

        // Check if the user already exists based on the provider's unique user ID
        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if (!$user) {
            // If the user doesn't exist, create a new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => '',
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'profile_picture' => $socialUser->getAvatar(),
            ]);
        }

        //dd($user);
        // Log the user in
        Auth::login($user, true);

        // Redirect to the home page or wherever you'd like
        return redirect()->route('dashboard');
    }
}
