<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\Attend;
use App\Models\EventInstances;
use App\Models\events;
use App\Models\follow;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class EventSignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function signup($event_id)
    {
        $myuser = Auth::user();
        $event = events::where('id', $event_id)->firstOrFail();

        $data = [
            "user_id" => $myuser->id,
            "event_id" => $event->id,
        ];

        $myuser->attends()->create($data);

        return redirect()->back()->with([
            'message' => 'You have signed up to this event!',
            'type' => 'success'
        ]);
    }

    public function withdraw($event_id)
    {
        $Attend = Attend::where('user_id', Auth::id())->where('event_id', $event_id)->first();
        $Attend->delete();
        return redirect()->back()->with([
            'message' => 'You have withdrawn to this event!',
            'type' => 'danger'
        ]);
    }


    public function privatesignup($key)
    {
        $event = events::where('key', $key)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id == $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $data = [
            "user_id" => $myuser->id,
            "event_id" => $event->id,
        ];
        $myuser->attends()->create($data);
        return redirect('event/' . $event->id)->with([
            'type' => "success",
            'message' => 'You have signed up!',
        ]);
    }

    public function certificate($eid)
    {
        $event = events::where('id', $eid)->firstOrFail();
        $myuser = Auth::user();
        $isattend = Attend::where('event_id', $eid)->where('user_id', $myuser->id)->firstOrFail();
        $eventInstances = EventInstances::where('event_id', $eid)->count();
        $attend = att::where('event_id', $eid)->where('user_id', $myuser->id)->count();

        return view("users.cer", compact('event', 'eventInstances', 'attend', 'myuser'));
    }
}