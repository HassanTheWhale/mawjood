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

        $already = att::select('atts.id', 'atts.done', 'atts.qr', 'atts.face')
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
        $already->update(['done' => 1]);
        $already->update(['face' => 1]);

        return response('Image captured', 200);
    }
}