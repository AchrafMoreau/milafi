<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::where('user_id', Auth::user()->id)->get();
        $eventsArray = [];
        foreach ($events as $event) {
            $dateEnd = new \DateTime($event->end);
            $dateStart = new \DateTime($event->start);

            $endTime = $dateEnd->format('D M d Y H:i:s \G\M\TO (T)');
            $startTime = $dateStart->format('D M d Y H:i:s \G\M\TO (T)');
            $eventsArray[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                //  start and time should be return in this format : Sat Aug 31 2024 12:00:00 GMT+0100 (GMT+01:00) 
                // 'start' => $startTime,
                'end' => $event->end,
                'allDay' => $event->allDay,
                'className' => $event->type,
                'description' => $event->description,
                'location' => $event->location,
            ];
        }

        return response()->json($eventsArray);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $end = null;
        $start = new \DateTime();
        if(!empty($request->endTime) && $request->endTime != 'Invalid Date'){
            $eventEnd = preg_replace('/\s*\(.*\)$/', '', $request->endTime);
            $end = new \DateTime($eventEnd);
        } 
        if(!empty($request->startTime) && $request->startTime != 'Invalid Date'){
            $eventStart = preg_replace('/\s*\(.*\)$/', '', $request->startTime);
            $start = new \DateTime($eventStart);
        }

        
        // dd($request->id);
        $event = Event::create([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
            'type' => $request->className,
            'location' => $request->location,
            'allDay' => $request->eventDay,
            'start' => $start,
            'end' => $end,
            'description' => $request->description,
            'title' => $request->title
        ]);

        

        return response()->json(['id' => $request->id, 'eventDay' => $event->allDay, 'className'=>$event->type, 'location' => $event->location, 'startTime' => $event->start, 'endTime' => $event->end, 'description' => $event->description, 'title' => $event->title ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $event = Event::findOrFail($id);
        // dd($event);

        $end = null;
        $start = null;

        if($request->endTime != 'Invalid Date'){
            $eventEnd = preg_replace('/\s*\(.*\)$/', '', $request->endTime);
            $end = new \DateTime($eventEnd);
        } 
        if($request->startTime != 'Invalid Date'){
            $eventStart = preg_replace('/\s*\(.*\)$/', '', $request->startTime);
            $start = new \DateTime($eventStart);
        }
        // dd($request->description);
        // $event->id = $request->id;
        $event->user_id = Auth::user()->id;
        $event->type = $request->className;
        $event->location = $request->location;
        $event->allDay = $request->eventDay;
        $event->start = $start;
        $event->end = $end;
        $event->description = $request->description;
        $event->title = $request->title;

        $event->save();

        return response()->json(['id' => $event->id, 'evenDay' => $event->allDay, 'className'=>$event->type, 'location' => $event->location, 'startTime' => $event->start, 'endTime' => $event->end, 'description' => $event->description, 'title' => $event->title ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Event::where('id', $id)->delete();
        $events = Event::All();
        // return response()->json($events);
    }
}
