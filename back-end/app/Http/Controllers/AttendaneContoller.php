<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\Attend;
use App\Models\EventInstances;
use App\Models\events;
use Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;

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
        $event->update(['attendKeyUpdate' => Carbon::now()]);

        $url = "https://mawjood.click/attendEvent/" . $event->attendKey;
        $qrCode = QrCode::size('500')->format('svg')->generate($url);

        return view('events.qr', compact('event', 'qrCode'));
    }

    function attend($id)
    {
        $myuser = Auth::user();
        $event = events::where('attendKey', $id)->first();
        if (!$event) {
            $alreadyScanned = att::where('attendKey', $id)->where('user_id', $myuser->id)->firstOrFail();
            $event = events::where('id', $alreadyScanned->event_id)->firstOrFail();
        }

        if (!$myuser->verified)
            return redirect('event/' . $event->id)->with([
                'type' => "warning",
                'message' => 'You need to verifiy you account first',
            ]);
        else if ($event->user_id == $myuser->id) {
            return redirect('event/' . $event->id)->with([
                'type' => "warning",
                'message' => 'You are the owner of the event!',
            ]);
        } else if ($event->closed == 0) {
            return redirect('event/' . $event->id)->with([
                'type' => "warning",
                'message' => 'No one is allowed to take his/her attendance!',
            ]);
        } else {

            // check if registered
            $isRegistered = Attend::where('user_id', $myuser->id)->where('event_id', $event->id)->first();
            if (!$isRegistered)
                return redirect('event/' . $event->id)->with([
                    'type' => "warning",
                    'message' => 'You need to signup first to the event',
                ]);

            // check time diff
            $timestamp = Carbon::parse($event->attendKeyUpdate);
            $secondsPassed = $timestamp->diffInSeconds(Carbon::now());
            if ($secondsPassed >= 15) {
                return redirect('event/' . $event->id)->with([
                    'type' => "warning",
                    'message' => 'QR Code has changed. Please re-scan it.',
                ]);
            }
        }

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face', 'atts.voice', 'atts.geo', 'atts.geoCheck')
            ->join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', Carbon::today()->format('Y-m-d'))
            ->first();

        $instance = EventInstances::where('event_id', $event->id)
            ->whereDate('date', Carbon::today()->format('Y-m-d'))
            ->first();

        if ($already) {
            if ($already->qr == 1 && $already->face >= 1 && $already->voice >= 1 && $already->done == 1)
                return redirect('event/' . $event->id)->with([
                    'type' => "warning",
                    'message' => 'You already have taken your attendance!',
                ]);
            else if ($already->qr == 1 && $already->face >= 1 && $already->voice >= 1 && $already->done == 0) {

                $geo = $event->geo;
                $userGeo = $already->geo;

                $point1 = explode(",", $geo);
                $point2 = explode(",", $userGeo);

                $lat1 = $point1[0];
                $lon1 = $point1[1];
                $lat2 = $point2[0];
                $lon2 = $point2[1];
                $lat1 = deg2rad($lat1);
                $lon1 = deg2rad($lon1);
                $lat2 = deg2rad($lat2);
                $lon2 = deg2rad($lon2);

                // Calculate the distance using the Haversine formula
                $deltaLat = $lat2 - $lat1;
                $deltaLon = $lon2 - $lon1;
                $earthRadius = 6371; // in km
                $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLon / 2) * sin($deltaLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $distance = $earthRadius * $c;

                if ($distance <= 5) {
                    $avgX = ($point1[0] + $point2[0]) / 2;
                    $avgY = ($point1[1] + $point2[1]) / 2;
                    $avgPoint = $avgX . ',' . $avgY;
                    $event->update(['geo' => $avgPoint]);
                    $already->update(['geoCheck' => 1]);
                } else {
                    $already->update(['geoCheck' => 2]);
                }

                $already->update(['done' => 1]);
                return redirect('event/' . $event->id)->with([
                    'type' => "success",
                    'message' => 'You have taken your attendance!',
                ]);
            } else if ($already->qr == 1 && $already->face >= 1 && $already->voice >= 0)
                return view('events.voice', compact('event', 'myuser', 'instance'));
            else if ($already->qr == 1 && $already->face == 0 && $already->voice == 0)
                $already->delete();
            else
                $already->delete();
        }


        if ($instance) {
            $attend = att::create([
                'user_id' => $myuser->id,
                'event_id' => $event->id,
                'instance_id' => $instance->id,
                'qr' => 1,
                'attendKey' => $id,
            ]);
            return view('events.face', compact('event', 'myuser', 'instance'));
        } else {
            return redirect('home/')->with([
                'type' => "warning",
                'message' => 'Today is not part of the event!',
            ]);
        }
    }
}