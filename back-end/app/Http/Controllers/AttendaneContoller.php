<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\Attend;
use App\Models\EventInstances;
use App\Models\events;
use Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendaneContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function generateQRCode($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $Attendkey = uniqid();
        $Attendkey = substr($Attendkey, 0, 10);
        $event->update(['attendKey' => $Attendkey]);

        $url = "http://localhost:8000/attendEvent/" . $event->attendKey;
        $qrCode = QrCode::size(250)->generate($url);

        return view('events.qr', compact('event', 'qrCode'));
    }

    function open($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $event->update(['closed' => 1]);
        return redirect('generateQR/' . $id . '/');
    }

    function close($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $event->update(['closed' => 0]);
        return redirect('generateQR/' . $id . '/');
    }

    function attend($id)
    {
        $event = events::where('attendKey', $id)->firstOrFail();
        $myuser = Auth::user();

        if ($event->user_id == $myuser->id) {
            return redirect('event/' . $event->id)->with([
                'type' => "warning",
                'message' => 'You are the owner of the event!',
            ]);
        } else if ($event->closed == 1) {
            return redirect('home/' . $event->id)->with([
                'type' => "warning",
                'message' => 'No one is allowed to take his/her attendance!',
            ]);
        }

        $already = att::join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', date('Y-m-d'))
            ->first();

        if ($already) {
            return redirect('event/' . $event->id)->with([
                'type' => "warning",
                'message' => 'You already have taken your attendance!',
            ]);
        }

        $instance = EventInstances::where('event_id', $event->id)
            ->whereDate('date', date('Y-m-d'))
            ->first();


        if ($instance) {
            $attend = att::create([
                'user_id' => $myuser->id,
                'event_id' => $event->id,
                'instance_id' => $instance->id,
            ]);

            if ($attend) {
                return redirect('event/' . $event->id)->with([
                    'type' => "success",
                    'message' => 'You have taken your attendance!',
                ]);
            } else {
                return redirect('home/')->with([
                    'type' => "warning",
                    'message' => 'Today is not part of the event!',
                ]);
            }


        } else {
            return redirect('home/')->with([
                'type' => "warning",
                'message' => 'Today is not part of the event!',
            ]);
        }
    }
}