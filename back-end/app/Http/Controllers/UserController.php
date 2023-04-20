<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\follow;
use app\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    // check if user is login always
    public function __construct()
    {
        $this->middleware('auth');
    }

    // load profile view
    public function profile()
    {
        $user = Auth::user();
        $countFollowers = follow::where('follow_id', $user->id)->count();
        $countFollowing = follow::where('user_id', $user->id)->count();
        $events = events::where('user_id', $user->id)->get();
        $verified = $user->verified;
        return view('users.profile', compact('user', 'countFollowers', 'countFollowing', 'events', 'verified'));
    }

    public function verify()
    {
        $user = Auth::user();
        if ($user->verified)
            return redirect('/profile');
        return view('users.auth', compact('user'));
    }


    public function verifyPost(Request $request)
    {
        $validatedData = $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'voice' => 'required|mimes:mp3,wav|max:2048',
        ]);

        $user = Auth::user();

        // Generate unique names for the uploaded files
        $pictureName = uniqid('picture_') . '.' . $request->file('picture')->extension();
        $voiceName = uniqid('voice_') . '.' . $request->file('voice')->extension();

        Storage::disk('s3')->putFileAs('authPic', $request->file('picture'), $pictureName, 'public');
        Storage::disk('s3')->putFileAs('authVoice', $request->file('voice'), $voiceName, 'public');

        $user->vpicture = Storage::disk('s3')->url('authPic/' . $pictureName);
        $user->vaudio = Storage::disk('s3')->url('authVoice/' . $voiceName);
        $user->verified = 1;

        $user->save();
        return redirect('/profile');
    }

    // load search view
    public function search(Request $request)
    {
        $query = $request->input('search');

        if ($request->has('search')) {
            $users = User::where('username', 'LIKE', '%' . $query . '%')->where('type', 0)->take(5)->get();
            return view('users.search', ['users' => $users, 'query' => $query]);
        } else {
            return view('users.search', ['users' => [], 'query' => ""]);
        }

    }

    // load other user view
    public function user($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $followed = follow::where('user_id', Auth::id())->where('follow_id', $user->id)->exists();
        $countFollowers = follow::where('follow_id', $user->id)->count();
        $countFollowing = follow::where('user_id', $user->id)->count();
        // check if the user are the same, go to the same
        $myuser = Auth::user();
        if ($user->id == $myuser->id || $user->type == 1)
            return redirect("profile")->with('user', $myuser);

        return view('users.user', compact('user', 'followed', 'countFollowers', 'countFollowing'));
    }

    // load edit view
    public function edit()
    {
        $user = Auth::user();
        return view('users.editUser', compact('user'));
    }

    // update user profile
    public function update(Request $request)
    {
        // $request->validate([
        //     'userName' => ['bail', 'required', 'string', 'max:255'],
        //     'userIDName' => ['bail', 'required', 'string', 'max:255'],
        //     // 'userBio' => ['bail', 'string', 'max:255'],
        //     // 'userEmail' => ['bail', 'required', 'string', 'email', 'max:255'],
        //     'userPrivate' => ['bail', 'integer'],
        // ]);
        $validatedData = $request->validate([
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($request);
        // Generate unique names for the uploaded files
        $user = Auth::user();

        if (isset($request['picture'])) {
            $picture = $request->file('picture');
            $pictureName = uniqid('picture_') . '.' . $picture->getClientOriginalExtension();
            Storage::disk('s3')->putFileAs('profile', $picture, $pictureName, 'public');
            $pictureUrl = Storage::disk('s3')->url('profile/' . $pictureName);
        } else
            $pictureName = $user->picture;

        $user->update([
            'name' => $request['userName'],
            'username' => $request['userIDName'],
            // 'email' => $request['userEmail'],
            'bio' => $request['userBio'],
            'picture' => $pictureUrl,
            'type' => is_null($request['userPrivate']) ? 0 : $request['userPrivate'],
        ]);

        return redirect("profile")->with('message', "Information was Updated");
    }
}