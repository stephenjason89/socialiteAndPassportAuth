<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Social_account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Exception;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialController extends Controller
{
    public function redirectSocial($provider)
    {
//        dd();
        return Socialite::driver($provider)
            ->with(['state' => request()->query('state')])
            ->redirect();
//        return Socialite::driver($provider)->redirect();
    }

    public function runCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $user = $this->findOrCreate($socialUser, $provider);

            Auth::login($user);
//            for ($access_token = null, $api = $this->apiLogin($socialUser, $provider), $retry = 0; $retry < 3; $retry++) {
//                $access_token = $api ? $api['access_token'] : null;
//                if ($api) break;
//            }
//            //todo: handle if login to api fails
            $access_token = $user->createToken(null)->accessToken;
            setcookie("access_token", $access_token, time() + 3600, "/", "", 0);

            return redirect(env('APP_URL') . RouteServiceProvider::HOME);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }

    public function runCallback2 ($provider)
    {
//        dd(request());
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $user = $this->findOrCreate($socialUser, $provider);

            Auth::login($user);

            $query = http_build_query([
                'client_id' => '4',
                'redirect_uri' => env('NUXT_URL') . '/callback',
                'response_type' => 'code',
                'scope' => '*',
                'state' => request()->query('state'),
            ]);

            return redirect(env('APP_URL') . '/oauth/authorize?' . $query);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function nuxtSocial($provider)
    {
        $socialUser = Socialite::driver($provider)->userFromToken(request()->bearerToken());

        return response()->json($socialUser);

    }

    private function apiLogin($socialUser, $provider)
    {
        $requestToken = [
            'grant_type' => 'social',
            'client_id' => config('lighthouse-graphql-passport.client_id'),
            'client_secret' => config('lighthouse-graphql-passport.client_secret'),
            'provider' => $provider,
            'access_token' => $socialUser->token,
        ];

        $request = Request::create('oauth/token', 'POST', $requestToken, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);

        return $response->getStatusCode() == 200 ? json_decode($response->getContent(), true) : false;
    }

    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = Social_account::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (!$user) {
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'nickname' => $providerUser->getNickname(),
                    'email' => $providerUser->getEmail(),
                    'avatar' => $providerUser->getAvatar(),
                ]);
            }
            $user->social_accounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }
}
