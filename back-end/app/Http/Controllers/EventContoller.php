<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\eventCategory;
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
        $categories = eventCategory::all();
        return view('events.create', compact('categories'));
    }

    public function event($id)
    {
        $myuser = Auth::user();
        $event = events::where('id', $id)->firstOrFail();
        $attend = Attend::where('user_id', Auth::id())->where('event_id', $id)->first();
        return view('events.event', compact('event', 'myuser', 'attend'));
    }

    public function modify($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $categories = eventCategory::all();
        return view('events.modify', compact('event', 'categories'));
    }

    public function createEvent(Request $request)
    {
        // $validatedData = $request->validate([
        //         'eventName' => 'required|max:50',
        //         'eventDesc' => 'required|max:50',
        //         'eventGrade' => 'required|integer|min:0',
        //     'eventPic' => 'required|image',
        //         'start_date' => 'required',
        // ]);

        $myuser = Auth::user();

        if (!is_null($request->file("eventPic"))) {
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
                'end_date' => $request->input('eventEDate'),
                'category' => $request->input('eventCategory'),
                'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
                'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
            ]);
        } else {
            $event = events::create([
                'user_id' => $myuser->id,
                'name' => $request->input('eventName'),
                'description' => $request->input('eventDesc'),
                'min_grade' => $request->input('eventGrade'),
                'start_date' => $request->input('eventSDate'),
                'end_date' => $request->input('eventEDate'),
                'category' => $request->input('eventCategory'),
                'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
                'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
            ]);
        }



        if ($event) {
            return redirect('event/' . $event->id)->with([
                'type' => "success",
                'message' => 'Event was created!',
            ]);
        } else {
            return redirect('home/')->with([
                'type' => "danger",
                'message' => 'Event was not created!',
            ]);
        }
    }


    public function modifyEvent(Request $request, $id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        if (!is_null($request->file("eventPic"))) {
            $image = $request->file('eventPic');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $event->update([
                'user_id' => $event->user_id,
                'name' => $request->input('eventName'),
                'description' => $request->input('eventDesc'),
                'picture' => $filename,
                'min_grade' => $request->input('eventGrade'),
                'start_date' => $request->input('eventSDate'),
                'end_date' => $request->input('eventEDate'),
                'category' => $request->input('eventCategory'),
                'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
                'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
            ]);
        } else {
            $event->update([
                'user_id' => $event->user_id,
                'name' => $request->input('eventName'),
                'description' => $request->input('eventDesc'),
                'min_grade' => $request->input('eventGrade'),
                'start_date' => $request->input('eventSDate'),
                'end_date' => $request->input('eventEDate'),
                'category' => $request->input('eventCategory'),
                'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
                'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
            ]);
        }



        if ($event) {
            return redirect('event/' . $event->id)->with([
                'type' => "success",
                'message' => 'Event was created!',
            ]);
        } else {
            return redirect('event' . $event->id)->with([
                'type' => "error",
                'message' => 'Event was not created!',
            ]);
        }
    }
}