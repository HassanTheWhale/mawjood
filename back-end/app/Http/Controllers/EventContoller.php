<?php

namespace App\Http\Controllers;

use App\Models\events;
use Auth;
use Illuminate\Http\Request;

class EventContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function myEvent()
    // {
    //     return view('events.myEvents');
    // }

    public function create()
    {
        return view('events.create');
    }

    public function createEvent(Request $request)
    {
        // I need to check how this works!

        $validatedData = $request->validate([
            //     'eventName' => 'required|max:50',
            //     'eventDesc' => 'required|max:50',
            //     'eventGrade' => 'required|integer|min:0',
            // 'eventPic' => 'required|image',
            //     'start_date' => 'required',
        ]);

        $myuser = Auth::user();

        $image = $request->file('eventPic');
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $filename);

        $event = events::create([
            'user_id' => $myuser->id,
            'name' => $request->input('eventName'),
            'description' => $request->input('eventDesc'),
            'picture' => $filename,
            'min_grade' => $request->input('eventGrade'),
            'start_date' => $request->input('eventSDate'),
            'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
            'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
        ]);

        if ($event) {
            return redirect('myEvents')->with([
                'type' => "success",
                'message' => 'Event was created!',
            ]);
        } else {
            return redirect('myEvents')->with([
                'type' => "error",
                'message' => 'Event was not created!',
            ]);
        }
    }
}