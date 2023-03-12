<?php

namespace App\Http\Controllers;

use App\Models\Attend;
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
}