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

    public function follow($id)
    {
        $myuser = Auth::user();
        $another_user = User::where('id', $id)->firstOrFail();

        $data = [
            "user_id" => $myuser->id,
            "follow_id" => $another_user->id,
        ];

        $myuser->follows()->create($data);

        return redirect()->back()->with('message1', 'Follow Done!');
    }

    public function unfollow($id)
    {
        $follow = follow::where('user_id', Auth::id())->where('follow_id', $id)->first();
        $follow->delete();
        return redirect()->back()->with('message1', 'Unfollow Done!');
    }
}