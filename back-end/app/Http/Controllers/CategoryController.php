<?php

namespace App\Http\Controllers;

use App\Models\events;
use Illuminate\Http\Request;

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
}