<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function event()
    {
        return view('event');
    }

    public function attendee()
    {
        return view('attendee');
    }

    public function categories()
    {
        return view('categories');
    }
}
