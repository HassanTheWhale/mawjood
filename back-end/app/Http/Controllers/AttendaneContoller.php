<?php

namespace App\Http\Controllers;

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

        $url = "http://localhost:8000/attendEvent/" . $id;
        $qrCode = QrCode::size(250)->generate($url);

        return view('events.qr', compact('event', 'qrCode'));
    }
}