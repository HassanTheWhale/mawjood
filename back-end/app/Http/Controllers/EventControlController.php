<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\events;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function check($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $registered = Attend::where('event_id', $event->id)->count();

        return view('events.check', compact('event', 'registered'));
    }

    public function checkAttendance($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $users = Attend::where('event_id', $id)->join('users', 'users.id', '=', 'attends.user_id')->get();
        return view('events.checkAttendance', compact('event', 'users'));
    }

    public function checkAttendanceUser($event_id, $user_id)
    {
        $event = events::where('id', $event_id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $user = User::where('id', $user_id)->firstOrFail();
        $attend = Attend::where('event_id', $event_id)->where('user_id', $user_id)->firstOrFail();



        return view('events.checkAttendanceUser', compact('event', 'user', 'attend'));
    }
}