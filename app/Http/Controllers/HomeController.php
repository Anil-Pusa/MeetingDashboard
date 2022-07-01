<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use Auth;

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
    {   $data = Meeting::whereNull('deleted_at')->where('user_id', Auth::user()->id)->get();
        return view('home',compact('data'));
    }

    public function addMeeting(Request $request){

        $request->validate([
            'event_name' => 'required',
            'name' => 'required',
            'mobile_number' => 'required',
            'key_note' => 'required',
            'meeting_slot' => 'required'
        ]);

        $createMeeting = Meeting::create([
            'event_name' => $request->event_name,
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'key_note' => $request->key_note,
            'meeting_slot' => $request->meeting_slot,
            'user_id' => Auth::user()->id
        ]);
        // dd($createMeeting);

        return redirect('/home')->with('message','Meeting added successfully');
    }

    public function editMeeting(Request $request){

        $request->validate([
            'eventId' => 'required',
            'event_name' => 'required',
            'name' => 'required',
            'mobile_number' => 'required',
            'key_note' => 'required'
        ]);

        $createMeeting = Meeting::where('id',$request->eventId)->update([
            'event_name' => $request->event_name,
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'key_note' => $request->key_note,
            'user_id' => Auth::user()->id
        ]);
        // dd($createMeeting);

        return redirect('/home')->with('message','Meeting updated successfully');
    }

    public function getMeeting(Request $request){
        $getMeeting = Meeting::whereNull('deleted_at')->where('id', $request->id)->first();

        return response()->json($getMeeting);
    }

    public function deleteMeeting(Request $request){
        
        $request->validate([
            'eventIdDel' => 'required'
        ]);

        $createMeeting = Meeting::where('id',$request->eventIdDel)->update([
            'deleted_at' => now()
        ]);
        // dd($createMeeting);

        return redirect('/home')->with('message','Meeting deleted successfully');
    }
}
