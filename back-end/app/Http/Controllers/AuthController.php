<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function captureImage(Request $request, $eid, $uid, $iid)
    {
        $myuser = Auth::user();
        $event = events::where('id', $eid)->firstOrFail();

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face', 'atts.geo')
            ->join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', Carbon::today()->format('Y-m-d'))
            ->firstOrFail();

        if ($already->done == 1 || $already->face == 1 || $already->qr == 0)
            return response('Image cant be captured', 404);

        $imageData = $request->input('image');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageBinary = base64_decode($imageData);
        $filename = uniqid() . '.png';
        $path = public_path('images/' . $filename);

        // check if face done
        // $already->update(['done' => 1]);
        $already->update(['face' => 1]);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $loc = $latitude . ',' . $longitude;
        $already->update(['geo' => $loc]);

        return response('Image captured', 200);
    }

    public function captureVoice(Request $request, $eid, $uid, $iid)
    {
        $audioData = $request->input('audio_data');
        $audioData = base64_decode($audioData);
        $filename = uniqid() . '.wav';

        // save the audio file to the storage/app/public directory
        // Storage::disk('public')->put($filename, $audioData);

        $myuser = Auth::user();
        $event = events::where('id', $eid)->firstOrFail();

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face', 'atts.voice', 'atts.geo')
            ->join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $myuser->id)
            ->whereDate('event_instances.date', Carbon::today()->format('Y-m-d'))
            ->firstOrFail();

        if ($already->done == 1 || $already->face == 0 || $already->qr == 0 || $already->voice == 1)
            return response('Image cant be captured', 404);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $loc = $latitude . ',' . $longitude;
        $geo = $already->geo;

        list($lat1, $long1) = explode(',', $loc);
        list($lat2, $long2) = explode(',', $geo);

        $avgLat = ($lat1 + $lat2) / 2;
        $avgLong = ($long1 + $long2) / 2;

        $avgGeoLocation = $avgLat . ',' . $avgLong;

        $already->update(['voice' => 1]);

        $already->update(['geo' => $avgGeoLocation]);

        return response('Voice captured', 200);
    }
}