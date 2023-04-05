<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

// use Microsoft\Graph\Graph;
// use Microsoft\Graph\Model\User as MicrosoftUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function username()
    {
        return 'username';
    }


    // public function redirectToMicrosoft()
    // {
    //     return Socialite::driver('microsoft-graph')->redirect();
    // }

    // public function handleMicrosoftGraphCallback()
    // {
    //     $graph = new Graph();
    //     $graph->setAccessToken($token);

    //     $graphUser = $graph->createRequest('GET', '/me')
    //         ->setReturnType(MicrosoftUser::class)
    //         ->execute();

    //     $existingUser = User::where('email', $graphUser->getMail())->first();

    //     if ($existingUser) {
    //         Auth::login($existingUser, true);
    //     } else {
    //         $newUser = User::create([
    //             'name' => $graphUser->getDisplayName(),
    //             'username' => $graphUser->getMail(),
    //             'email' => $graphUser->getMail(),
    //             'password' => bcrypt(Str::random(16)),
    //         ]);

    //         Auth::login($newUser, true);
    //     }

    //     return redirect('/home');
    // }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $username = str_replace([' ', '-'], '', $user->name);
            $username = strtolower($username);
            $existingUsername = User::where('username', $username)->first();
            if ($existingUsername) {
                $i = 1;
                while ($existingUsername) {
                    $newUsername = $username . $i;
                    $existingUser = User::where('username', $newUsername)->first();
                    $i++;
                }
                $username = $newUsername;
            }
            $newUser = User::create([
                'name' => $user->name,
                'username' => $username,
                'email' => $user->email,
                'password' => bcrypt(Str::random(16)),
            ]);

            Auth::login($newUser, true);
        }

        return redirect('/home');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}