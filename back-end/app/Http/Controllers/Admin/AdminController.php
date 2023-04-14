<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventInstances;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\events;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $totalUsers = User::count();
        $verifiedUsers = User::where('verified', 1)->count();
        $totalEvents = events::count();
        $totalEventsToday = EventInstances::where('date', Carbon::today())->count();
        return view('admin.home', compact('totalUsers', 'verifiedUsers', 'totalEvents', 'totalEventsToday'));
    }


    public function user()
    {
        $users = User::get();
        return view('admin.user', compact('users'));
    }


    public function event()
    {
        $events = events::join('event_categories', 'events.category', '=', 'event_categories.id')->select('events.*', 'event_categories.name as categoryName')->get();
        return view('admin.event', compact('events'));
    }

    public function removeEvent($id)
    {
        $event = events::find($id);

        if ($event) {
            $event->delete();
            return redirect()->route('admin.event')->with('success', 'Event deleted successfully');
        } else {
            return redirect()->route('admin.event')->with('error', 'Event not found');
        }
    }

    public function removeUser($id)
    {
        $user = User::find($id);
        $myuser = Auth::user();

        if ($user->id == $myuser->id)
            return redirect()->route('admin.user')->with('error', 'You can not delete your user!');
        if ($user) {
            $user->delete();
            return redirect()->route('admin.user')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin.user')->with('error', 'User not found');
        }
    }
}