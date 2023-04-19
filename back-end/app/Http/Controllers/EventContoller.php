<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\eventCategory;
use App\Models\EventInstances;
use App\Models\events;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Log;

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
        $attend = null;
        if ($event->private == 1 && $event->user_id != $myuser->id)
            $attend = Attend::where('user_id', Auth::id())->where('event_id', $id)->firstOrFail();
        else
            $attend = Attend::where('user_id', Auth::id())->where('event_id', $id)->first();
        $dates = EventInstances::where("event_id", $event->id)->get();
        return view('events.event', compact('event', 'myuser', 'attend', 'dates'));
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
        $validatedData = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'nullable|string|max:255',
            'eventPrivate' => 'nullable|boolean',
        ]);
        $myuser = Auth::user();
        $array = [
            'user_id' => $myuser->id,
            'name' => $request->input('eventName'),
            'description' => $request->input('eventDesc'),
            'min_grade' => 0,
            'category' => $request->input('eventCategory'),
            'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
            'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
        ];

        if (!is_null($request->file("eventPic"))) {
            $image = $request->file('eventPic');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = Storage::disk('s3')->putFileAs('images', $image, $filename, 'public');
            $pictureUrl = Storage::disk('s3')->url('profile/' . $filename);
            $array['picture'] = $pictureUrl;
        }

        $key = uniqid();
        $key = substr($key, 0, 10);
        $array['key'] = $key;
        $Attendkey = uniqid();
        $Attendkey = substr($Attendkey, 0, 10);
        $array['attendKey'] = $Attendkey;

        $dateType = $request->input('date_type');
        if ($dateType === 'single') {
            $array['start_time'] = $request->input('eventSTimeA');
            $array['end_time'] = $request->input('eventETimeA');
            $array['start_date'] = $request->input('eventSDateA');
            $array['end_date'] = $request->input('eventSDateA');
            $array['type'] = 0;
        } else {
            $array['start_time'] = $request->input('eventSTimeB');
            $array['end_time'] = $request->input('eventETimeB');
            $array['start_date'] = $request->input('eventSDateB');
            $array['end_date'] = $request->input('eventEDateB');
            $array['type'] = 1;
        }

        $event = events::create($array);

        $startDate = Carbon::parse($array['start_date']);
        $endDate = Carbon::parse($array['end_date']);
        $weekdays = $request->input('weekdays') ?? null;


        if ($dateType === 'single') {
            $date = $startDate->format('Y-m-d');
            $event->dates()->create([
                'date' => $date,
            ]);
        } else {
            $weekdays = array_keys($weekdays);
            if ($weekdays == null) {
                return redirect('home/')->with([
                    'type' => "danger",
                    'message' => 'Event was not created because you didn\'nt mention the weekdays!',
                ]);
            }
            $currentDate = Carbon::parse($startDate->format('Y-m-d'));
            while ($currentDate->lte($endDate)) {
                if (in_array($currentDate->dayOfWeek, $weekdays)) {
                    $event->dates()->create([
                        'date' => $currentDate->format('Y-m-d'),
                    ]);
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
        $validatedData = $request->validate([
            'eventName' => 'required|string|max:255',
            'eventDesc' => 'nullable|string|max:255',
            'eventPrivate' => 'nullable|boolean',
        ]);
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $array = [
            'user_id' => $myuser->id,
            'name' => $request->input('eventName'),
            'description' => $request->input('eventDesc'),
            'min_grade' => 0,
            'category' => $request->input('eventCategory'),
            'strange' => is_null($request->input('eventStrange')) ? 0 : $request->input('eventStrange'),
            'private' => is_null($request->input('eventPrivate')) ? 0 : $request->input('eventPrivate'),
        ];

        if (!is_null($request->file("eventPic"))) {
            $image = $request->file('eventPic');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = Storage::disk('s3')->putFileAs('images', $image, $filename, 'public');
            $pictureUrl = Storage::disk('s3')->url('profile/' . $filename);
            $array['picture'] = $pictureUrl;
        }

        $dateType = $request->input('date_type');
        if ($dateType === 'single') {
            $array['start_time'] = $request->input('eventSTimeA');
            $array['end_time'] = $request->input('eventETimeA');
            $array['start_date'] = $request->input('eventSDateA');
            $array['end_date'] = $request->input('eventSDateA');
            $array['type'] = 0;
        } else {
            $array['start_time'] = $request->input('eventSTimeB');
            $array['end_time'] = $request->input('eventETimeB');
            $array['start_date'] = $request->input('eventSDateB');
            $array['end_date'] = $request->input('eventEDateB');
            $array['type'] = 1;
        }

        $event->update($array);

        $startDate = Carbon::parse($array['start_date']);
        $endDate = Carbon::parse($array['end_date']);
        $weekdays = $request->input('weekdays') ?? null;
        if ($weekdays == null) {
            return redirect('event/' . $event->id);
        }
        $weekdays = array_keys($weekdays);

        $event->dates()->delete();
        $create = null;
        if ($dateType === 'single') {
            $date = $startDate->format('Y-m-d');
            $event->dates()->create([
                'date' => $date,
            ]);
        } else {
            $currentDate = Carbon::parse($startDate->format('Y-m-d'));
            while ($currentDate->lte($endDate)) {
                if (in_array($currentDate->dayOfWeek, $weekdays)) {
                    $create = $event->dates()->create([
                        'date' => $currentDate->format('Y-m-d'),
                    ]);
                }
                $currentDate->addDay();
            }
        }

        if ($event->wasChanged() || count($event->getChanges()) > 0 || $create) {
            return redirect('event/' . $event->id)->with([
                'type' => "success",
                'message' => 'Event was modified!',
            ]);
        } else {
            return redirect('event/' . $event->id)->with([
                'type' => "danger",
                'message' => 'Event was not modified!',
            ]);
        }
    }
    public function privateKey($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        return view('events.privateKey', compact('event'));
    }

    public function privateKeyModify(Request $request, $id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $key = uniqid();
        $key = substr($key, 0, 10);
        $event->key = $key;
        $event->save();
        return redirect('PrivateKey/' . $event->id)->with([
            'type' => "success",
            'message' => 'Private Key was Modified!',
        ]);
    }
}