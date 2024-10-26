<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create($data);

        if($user) {
            return redirect()->route('login');
        }
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($data)){
            return redirect()->route('dashboard');
        }
    }

    public function dashboardPage(){
        if(Auth::check()){
            $events = Event::all();
        $attendees = Attendee::all();
        $categories = Category::all();
            return view('dashboard', compact('events', 'attendees', 'categories'));
        }else{
            return redirect()->route('login');
        }
    }

    public function logout(){
        Auth::logout();
        return view('login');
    }
}
