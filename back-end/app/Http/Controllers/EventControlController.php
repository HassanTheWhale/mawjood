<?php

namespace App\Http\Controllers;

use App\Models\att;
use App\Models\Attend;
use App\Models\EventInstances;
use App\Models\events;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function check($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $registered = Attend::where('event_id', $event->id)->count();

        return view('events.check', compact('event', 'registered'));
    }

    public function checkAttendance($id)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $users = Attend::where('event_id', $id)->join('users', 'users.id', '=', 'attends.user_id')->get();


        $instances = EventInstances::where('event_id', $id)
            ->where('date', '<=', Carbon::today())
            ->get();

        $attendances = att::where('event_id', $id)
            ->whereIn('user_id', $users->pluck('user_id'))
            ->get()
            ->groupBy('user_id')
            ->map(function ($attendees, $user_id) use ($instances) {
                $attendedDays = $attendees->pluck('instance_id')->toArray();
                $absentDays = $instances->whereNotIn('id', $attendedDays)->pluck('date')->toArray();
                return [
                    'total_attends' => count($attendedDays),
                    'total_absent' => count($absentDays),
                    'total_days' => count($absentDays) + count($attendedDays),
                ];
            });

        return view('events.checkAttendance', compact('event', 'users', 'attendances'));
    }

    public function checkAttendanceUser($event_id, $user_id)
    {
        $event = events::where('id', $event_id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $user = User::where('id', $user_id)->firstOrFail();
        $attend = Attend::where('event_id', $event_id)->where('user_id', $user_id)->firstOrFail();

        $instances = EventInstances::where('event_id', $event_id)->get();
        $attendedDay = att::join('event_instances', 'atts.instance_id', '=', 'event_instances.id')
            ->where('atts.event_id', $event->id)
            ->where('atts.user_id', $user_id)
            ->get();

        $attendDays = array();
        $absentDays = array();
        $totalAttends = 0;
        $totalAbsent = 0;

        foreach ($instances as $instance) {
            // Use Carbon to compare dates
            $today = Carbon::today();
            $instanceDate = Carbon::parse($instance->date);
            if ($instanceDate->lte($today)) { // exclude future dates
                $flag = false;
                foreach ($attendedDay as $aday) {
                    if ($instance->id == $aday->instance_id) {
                        array_push($attendDays, $instance->date);
                        $flag = true;
                        $totalAttends++;
                        break;
                    }
                }
                if (!$flag) {
                    $totalAbsent++;
                    array_push($absentDays, $instance->date);

                }
            }
        }

        $totalDays = $totalAbsent + $totalAttends;
        return view('events.checkAttendanceUser', compact('event', 'user', 'attend', 'attendDays', 'absentDays', 'attendedDay', 'totalAttends', 'totalAbsent', 'totalDays'));
    }

    public function updateGrade(Request $request, $eid, $uid)
    {
        $event = events::where('id', $eid)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $attend = Attend::where("user_id", $uid)->where('event_id', $eid)->firstOrFail();
        $attend->grade = $request->input('grade');
        $attend->save();

        return redirect('/checkAttendance/' . $eid . '/' . $uid)->with([
            'type' => "success",
            'message' => 'Grade is updated!',
        ]);
    }

    public function setAbsent($eid, $uid, $date)
    {
        $event = events::where('id', $eid)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $instance = EventInstances::where('event_id', $event->id)
            ->where('date', Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'))->firstOrFail();

        att::where('event_id', $eid)
            ->where('user_id', $uid)
            ->where('instance_id', $instance->id)
            ->delete();

        return redirect('/checkAttendance/' . $eid . '/' . $uid)->with([
            'type' => "success",
            'message' => 'User set absent on ' . $date,
        ]);
    }

    public function setAttend($eid, $uid, $date)
    {
        $event = events::where('id', $eid)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }

        $instance = EventInstances::where('event_id', $event->id)
            ->where('date', Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'))->firstOrFail();

        att::create([
            'user_id' => $uid,
            'event_id' => $eid,
            'qr' => 1,
            'face' => 2,
            'voice' => 2,
            'geoCheck' => 3,
            'eventGeo' => '',
            'done' => 1,
            'instance_id' => $instance->id,
        ]);

        return redirect('/checkAttendance/' . $eid . '/' . $uid)->with([
            'type' => "success",
            'message' => 'User set attend on ' . $date,
        ]);
    }

    function open($id, $location)
    {
        $event = events::where('id', $id)->firstOrFail();
        $myuser = Auth::user();
        if ($event->user_id != $myuser->id) {
            return redirect('event/' . $event->id);
        }
        $event->update(['closed' => 1]);
        $event->update(['geo' => $location]);
        return response('qr done', 200);
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
}