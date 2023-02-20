<?php

namespace App\Http\Controllers;

use App\Models\follow;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class FollowControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow(User $user)
    {
        $myuser = Auth::user();

        $data = [
            "user_id" => $myuser->id,
            "follow_id" => $user->first()->id,
        ];

        $myuser->follows()->create($data);

        return redirect()->back()->with('message', 'Follow done');
    }

    public function unfollow(User $user)
    {
        $follow = follow::where('user_id', Auth::id())->where('follow_id', $user->first()->id)->first();
        $follow->delete();
        return redirect()->back()->with('message', 'UnFollow done');
    }
}