<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\eventCategory;
use App\Models\events;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function remove($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $event->delete();
        return redirect('home/')->with([
            'type' => "success",
            'message' => 'Event was removed!',
        ]);
    }

    public function createEvent(Request $request)
    {
        $myuser = Auth::user();
        $array = [
            'user_id' => $myuser->id,
            'name' => $request->input('eventName'),
            'description' => $request->input('eventDesc'),
            'min_grade' => $request->input('eventGrade'),
            'start_date' => Carbon::parse($request->input('eventSDate')),
            'end_date' => Carbon::parse($request->input('eventEDate')),
            'category' => $request->input('eventCategory'),
            'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
            'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
        ];

        if (!is_null($request->file("eventPic"))) {
            $image = $request->file('eventPic');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $array['picture'] = $filename;
        }

        $dateType = $request->input('date_type');

        if ($dateType === 'single') {
            $array['start_time'] = $request->input('eventSTimeA');
            $array['end_time'] = $request->input('eventETimeA');
        } else {
            $array['start_time'] = $request->input('eventSTimeB');
            $array['end_time'] = $request->input('eventETimeB');
        }

        $event = events::create($array);

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $startTime = $request->input('start_time') ?? null;
        $endTime = $request->input('end_time') ?? null;
        $weekdays = $request->input('weekdays') ?? null;

        if ($dateType === 'single') {
            $date = $startDate->format('Y-m-d') . ($startTime ? ' ' . $startTime : '');
            $event->dates()->create([
                'date' => $date,
            ]);
        } else {
            $currentDate = Carbon::parse($startDate->format('Y-m-d') . ' ' . $startTime);

            dd($startDate, $endDate);

            while ($currentDate->lte($endTime)) {
                if (in_array($currentDate->dayOfWeek, $weekdays)) {
                    $created = $event->dates()->create([
                        'date' => $currentDate->format('Y-m-d H:i:s'),
                    ]);
                    if (!$created) {
                        dd('Error creating date!');
                    }
                }
                $currentDate->addDay();
            }
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

        $array = [
            'user_id' => $myuser->id,
            'name' => $request->input('eventName'),
            'description' => $request->input('eventDesc'),
            'min_grade' => $request->input('eventGrade'),
            'start_date' => Carbon::parse($request->input('eventSDate')),
            'end_date' => Carbon::parse($request->input('eventEDate')),
            'category' => $request->input('eventCategory'),
            'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
            'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
        ];

        if (!is_null($request->file("eventPic"))) {
            $image = $request->file('eventPic');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $array['picture'] = $filename;
        }
        $event = events::create($array);

        if ($event) {
            return redirect('event/' . $event->id)->with([
                'type' => "success",
                'message' => 'Event was modified!',
            ]);
        } else {
            return redirect('home/')->with([
                'type' => "error",
                'message' => 'Event was not created!',
            ]);
        }
    }
}