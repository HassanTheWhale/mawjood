<?php

namespace App\Http\Controllers;

use App\Models\eventCategory;
use App\Models\events;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $events = events::all();
        $catergories = eventCategory::all();
        return view('home', compact('catergories'));
    }
}