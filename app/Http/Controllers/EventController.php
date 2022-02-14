<?php

namespace App\Http\Controllers;

use App\User;
use App\Event;
use Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\NewEvent;
use App\DataTables\EventDataTable;
use Brian2694\Toastr\Facades\Toastr;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventDataTable $dataTable)
    {
        return $dataTable->render('event.index');
    }

    public function calendar()
    {
        $events = Event::all();
        return view('event.calendar', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start = Carbon::parse($request->start)->toDateString();
        $event->end = Carbon::parse($request->end)->toDateString();
        $event->color = $request->color;
        $event->save();

        // send notification to all user
        $users = User::all();
        Notification::send($users, new NewEvent($event));

        Toastr::success('Event Successfully Created', 'Success');
        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('event.form', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'title' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start = Carbon::parse($request->start)->toDateString();
        $event->end = Carbon::parse($request->end)->toDateString();
        $event->color = $request->color;
        $event->save();
        Toastr::success('Event Successfully Updated', 'Success');
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Toastr::success('Event Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
