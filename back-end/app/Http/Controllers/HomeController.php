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
    public function index(Request $request)
    {
        if ($request->has('search') && $request->input('search') != '') {
            $query = $request->input('search');
            $events = events::where('name', 'LIKE', '%' . $query . '%')->where('private', 0)->take(5)->get();
            return view('home', ['events' => $events, 'query' => $query]);
        } else {
            $catergories = eventCategory::all();
            return view('home', ['catergories' => $catergories, 'query' => ""]);
        }
        // $events = events::all();

    }
}