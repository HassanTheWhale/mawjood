<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MicrosoftAuthController extends Controller
{
    public function redirectToMicrosoft()
    {
        $redirectUri = urlencode(route('microsoft.callback'));

        $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize' .
            '?client_id=' . config('services.microsoft.client_id') .
            '&response_type=code' .
            '&redirect_uri=' . $redirectUri .
            '&response_mode=query' .
            '&scope=' . urlencode('openid profile email User.Read');

        return redirect($url);
    }

    public function handleMicrosoftCallback(Request $request)
    {
        $tokenEndpoint = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
        $redirectUri = urlencode(route('microsoft.callback'));

        $response = Http::asForm()->post($tokenEndpoint, [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.microsoft.client_id'),
            'client_secret' => config('services.microsoft.client_secret'),
            'code' => $request->query('code'),
            'redirect_uri' => $redirectUri,
            'scope' => 'openid profile email User.Read',
        ]);

        $accessToken = $response['access_token'];

        $graphEndpoint = 'https://graph.microsoft.com/v1.0/me';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ])->get($graphEndpoint);

        $data = $response->json();

        $email = $data['mail'] ?? $data['userPrincipalName'];
        $displayName = $data['displayName'];

        // Find or create the user in your database
        $user = User::where('email', $email)->first();
        if (!$user) {
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
        }
        Auth::login($newUser, true);

        // Redirect to the intended URL or a default page
        return redirect()->intended('/home');
    }
}