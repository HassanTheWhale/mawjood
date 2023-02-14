<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myEvent()
    {
        return view('events.myEvents');
    }

    public function create()
    {
        return view('events.create');
    }
}