<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\events;
use App\Models\follow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category($id)
    {
        $events = events::where('category', $id)->where('private', 0)->get();
        return view('events.category', compact('events'));
    }

    public function following()
    {
        $myuser = Auth::user();
        $eventIds = Attend::whereIn('user_id', function ($query) use ($myuser) {
            $query->select('follow_id')

                ->from('follows')
                ->where('user_id', $myuser->id);
        })
            ->orWhere('user_id', $myuser->id)
            ->distinct()->pluck('event_id');
        // dd($eventIds);

        $events = events::whereIn('id', $eventIds)
            // ->where('end_date', '>=', Carbon::now())
            ->get();

        return view('users.following', compact('events'));
    }


}