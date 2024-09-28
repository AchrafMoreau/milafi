<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Cas;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use ArPHP\I18N\Arabic;



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
            // $dateEnd = new \DateTime($event->end);
            // $dateStart = new \DateTime($event->start);

            // $endTime = $dateEnd->format('Y-m-d'). "T" .$dateStart->format('H:i:s') . ".000Z";
            // $startTime = $dateStart->format('Y-m-d') . 'T' . $dateStart->format('H:i:s') . ".000Z";           
            // if($event->id == 5) dd($startTime, $event->start);
            $eventsArray[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' =>  $event->end,
                'allDay' => $event->allDay,
                'className' => $event->type,
                'description' => $event->description,
                'location' => $event->location,
            ];
        }

        // dd($eventsArray);

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

        // $end = null;
        // $start = new \DateTime();
        // if(!empty($request->endTime) && $request->endTime != 'Invalid Date'){
        //     $eventEnd = preg_replace('/\s*\(.*\)$/', '', $request->endTime);
        //     $end = new \DateTime($eventEnd);
        // } 
        // if(!empty($request->startTime) && $request->startTime != 'Invalid Date'){
        //     $eventStart = preg_replace('/\s*\(.*\)$/', '', $request->startTime);
        //     $start = new \DateTime($eventStart);
        // }

        
        $event = Event::create([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
            'type' => $request->className,
            'location' => $request->location,
            'allDay' => $request->eventDay,
            'start' => new \DateTime($request->start),
            'end' => $request->end ? new \DateTime($request->end) : null,
            'description' => $request->description,
            'title' => $request->title
        ]);

        // dd($event);
        

        return response()->json([
            'id' => $request->id, 
            'eventDay' => $event->allDay, 
            'className'=>$event->type, 
            'location' => $event->location, 
            'startTime' => $event->start, 
            'endTime' => $event->end,
            'description' => $event->description, 
            'title' => $event->title 
        ]);
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
        $event = Event::where('user_id', Auth::id())->findOrFail($id);
        // dd($event);

        // $end = null;
        // $start = null;

        // if($request->endTime != 'Invalid Date'){
        //     $eventEnd = preg_replace('/\s*\(.*\)$/', '', $request->endTime);
        //     $end = new \DateTime($eventEnd);
        // } 
        // if($request->startTime != 'Invalid Date'){
        //     $eventStart = preg_replace('/\s*\(.*\)$/', '', $request->startTime);
        //     $start = new \DateTime($eventStart);
        // }

        // dd($end, $start);
        // dd($request);
        // $event->id = $request->id;
        $event->user_id = Auth::user()->id;
        $event->type = $request->className;
        $event->location = $request->location;
        $event->allDay = $request->eventDay;
        $event->start = $request->startTime ? new \DateTime($request->startTime) : null;
        $event->end = $request->endTime ? new \DateTime($request->endTime) : null;
        // $event->start = $start;
        // $event->end = $end;
        $event->description = $request->description;
        $event->title = $request->title;

        $event->save();


        $notification = array(
            'message' => 'Event Updated successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Event::where('id', $id)
            ->where("user_id", Auth::id())
            ->delete();
        $events = Event::where('user_id', Auth::id());
        // return response()->json($events);
    }

    public function import(Request $req)
    {
        $req->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:start_date',
        ]);

        $procedure = Procedure::where('user_id', Auth::id())
            ->with([
                'cas' => function ($query) {
                    $query->with(['court', 'judge', 'client']); 
                }
            ])->whereBetween('date' , [$req->from, $req->to])
            ->get();

        $schedule = [];
        foreach($procedure as $proc){
            // Set the locale to Arabic for the day name only
            Carbon::setLocale('fr');
            $date = Carbon::parse($proc->date);

            // Get the day name in Arabic and manually format the rest with Western numerals
            $arabicDayName = $date->translatedFormat('l'); // Get the day name in Arabic
            $westernDate = $date->format('Y/m/d'); // Use Western numerals for the date
            $formattedDate = $arabicDayName . ' ' . $westernDate;

            $obj = [
                "court" => $proc->cas->court->name,
                "title_file" => $proc->cas->title_file,
                "serial_number" => $proc->cas->serial_number,
                "decision" => "",
                "client" => $proc->cas->client->name,
                "time" => $proc->time,
                "procedure" => $proc->procedure,
                "require" => ""
            ];
            if (array_key_exists($proc->date, $schedule)) {
                $schedule[$formattedDate][] = $obj;
            } else {
                $schedule[$formattedDate] = [$obj];
            }
        };

        $reportHtml = view('schedule', compact('schedule'))->render();

        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }
        // $pdf = PDF::loadHTML($reportHtml);
        $pdf = PDF::setOption('direction', 'rtl')->loadHTML($reportHtml);

        return $pdf->download('WeekSchedule.pdf');
        // return $pdf->stream();
        return view('schedule', compact('schedule'));
        
    }


    public function importSession()
    {

        $startOfWeek = Carbon::now()->startOfWeek(); // Get the start of the week (Monday)
        $endOfWeek = Carbon::now()->endOfWeek();     // Get the end of the week (Sunday)
        $session = Event::where('user_id', Auth::id())
            ->whereBetween('start' , [$startOfWeek, $endOfWeek])
            ->get();

        // dd($session);

        $schedule = [];
        foreach($session as $proc){
            // Set the locale to Arabic for the day name only
            Carbon::setLocale('fr');
            $date = Carbon::parse($proc->start);

            $arabicDayName = $date->translatedFormat('l'); // Get the day name in Arabic
            $westernDate = $date->format('Y/m/d'); // Use Western numerals for the date
            $formattedDate = $arabicDayName . ' ' . $westernDate;

            $start = new \DateTime($proc->start);
            $startTime = $start->format("H:i:s A");
            $end = $proc ? new \DateTime($proc->end) : null;
            $endTime = $end->format("H:i:s A");

            $type;
            switch($proc->type){
                case 'bg-success-subtle':
                    $type = "notImportant";
                    break;
                case 'bg-info-subtle':
                    $type = 'meeting';
                    break;
                case "bg-warning-subtle":
                    $type = 'session';
                    break;
                case 'bg-danger-subtle':
                    $type = 'veryImportant';
                    break;
                default:
                    $type= '';
            };
            $obj = [
                "title" => $proc->title,
                "location" => $proc->location,
                "description" => $proc->description,
                "type" => $type,
                'start_time' => $startTime,
                'end_time' => $endTime
            ];
            if (array_key_exists($formattedDate, $schedule)) {
                $schedule[$formattedDate][] = $obj;
            } else {
                $schedule[$formattedDate] = [$obj];
            }
        };

        // dd($schedule);
        $reportHtml = view('scheduleSession', compact('schedule'))->render();

        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p)-1; $i >= 0; $i-=2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
        }
        // $pdf = PDF::loadHTML($reportHtml);
        $pdf = PDF::setOption('direction', 'rtl')->loadHTML($reportHtml);

        return $pdf->download('WeekSchedule.pdf');
        // return $pdf->stream();
        // return view('scheduleSession', compact('schedule'));
        
    }
}
