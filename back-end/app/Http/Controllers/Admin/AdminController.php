<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventInstances;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\events;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $totalUsers = User::count();
        $verifiedUsers = User::where('verified', 1)->count();
        $totalEvents = events::count();
        $totalEventsToday = EventInstances::where('date', Carbon::today())->count();
        return view('admin.home', compact('totalUsers', 'verifiedUsers', 'totalEvents', 'totalEventsToday'));
    }


    public function user()
    {
        return view('admin.user');
    }


    public function event()
    {
        return view('admin.event');
    }
}