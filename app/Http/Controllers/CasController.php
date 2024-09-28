<?php

namespace App\Http\Controllers;

use App\Models\Cas;
use App\Models\Court;
use App\Models\Judge;
use App\Models\Client;
use App\Models\Procedure;
use App\Models\Document;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



class CasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $cases = Cas::with(['client','court','judege'])->Paginate(10);
        $cases = Cas::with(['client', 'court', 'judge'])->orderBy('created_at', "DESC")->paginate(10);
        return view('dashboard-cases', ['cas' => $cases]);
    }

    public function getAll()
    {
        $cases = Cas::with(['client', 'court', 'judge'])
            ->where('user_id', Auth::user()->id)
            ->get();
        return response()->json($cases, 200);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $clients = Client::where('user_id', Auth::user()->id)->get();
        $courts = Court::where('user_id', Auth::user()->id)
            ->orWhere('isDefault', 1)
            ->get();
        $judge = Judge::where('user_id', Auth::user()->id)
            ->orWhere('isDefault', 1)
            ->get();
        return view('cases.add-cas', ['courts' => $courts, 'judges' => $judge, 'clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $res)
    {
        //
        
        // dd($res->date && $req->desc && $req->invoice && $req->fee);
        // dd($res);
        $res->validate([
            'serial_number' => 'required',
            'court'=> 'required',
            'client' => 'required',
            'file_subject' => "required",
            'judge' => "required",
        ]);

        $cas = Cas::create([
            'user_id' => Auth::user()->id,
            'serial_number' => $res->serial_number,
            'court_id'=> $res->court,
            'client_id' => $res->client,
            'title_file' => $res->file_subject,
            'title_number' => $res->title_number,
            'judge_id' => $res->judge,
            'report_file' => $res->report_file,
            'execution_file' => $res->execution_file,
            'report_number' => $res->report_number,
            'execution_number' => $res->execution_number,
            'opponent' => $res->opponent,
            'status' => 'Open',
        ]);

         if($res->date && $res->procedure && $res->invoice && $res->fee && $res->time){
            Procedure::create([
                'user_id' => Auth::user()->id,
                'cas_id' => $cas->id,
                'time' => $res->time,
                'date' => $res->date,
                'procedure' => $res->procedure,
                'invoice' => $res->invoice,
                'fee' => $res->fee
            ]);
        }

        $notification = array(
            'message' => 'Case Created successfully',
            'alert-type' => 'success'
        );
        return redirect('/cas')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Cas $cas,$case)
    {
        //
        $ca = Cas::with(['client', 'court', 'judge', 'document', 'procedure'])
            ->where('user_id', Auth::user()->id)
            ->where('id', $case) 
            ->first();
        return view('cases.show-cas', ['case' => $ca]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $clients = Client::where('user_id', Auth::user()->id)->get();
        $courts = Court::where('user_id', Auth::user()->id)
            ->orWhere('isDefault', 1)
            ->get();
        $judge = Judge::where('user_id', Auth::user()->id)
            ->orWhere('isDefault', 1)
            ->get();
        $cas = Cas::with(['client', 'court', 'judge', 'document', 'procedure'])
            ->where('user_id', Auth::user()->id)
            ->where('id', $id) 
            ->first();
        return view('cases.edit-cas', ['case' => $cas, 'clients' => $clients, 'judges' => $judge, 'court' => $courts]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, $id)
    {
        //
        // dd($req->serial);
        $req->validate([
            'court'=> 'required',
            'client'=>'required',
            'judge' => 'required',
        ]);


        $cas = Cas::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        // $cas->serial_number = $req->serial_number;
        $cas->title_file = $req->title;
        $cas->title_number = $req->titleNumber;
        $cas->status = $req->status;
        $cas->court_id = $req->court;
        $cas->judge_id = $req->judge;
        $cas->client_id = $req->client;
        $cas->report_number = $req->reportNumber;
        $cas->execution_number = $req->executionNumber;
        $cas->report_file = $req->fileReport;
        $cas->execution_file = $req->fileExecution;
        $cas->opponent = $req->opponent;
        // -------------------------

        $cas->save();

        $notification = array(
            'message' => 'Case Updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMany(Request $req){
        
        $req->validate([
            'ids' => 'required|array',
        ]);
        Cas::where('user_id', Auth::id())->whereIn('id', $req->input('ids'))->delete();
        // $da = Cas::whereIn('serial_number', $req->input('ids'))
        //     ->where('user_id', Auth::user()->id)
        //     ->delete();
        $notification = array(
            'message' => 'Many Cases Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification, 200);
    }

    public function destroy($id)
    {
        //
        Cas::where('id', $id)
            ->where("user_id", Auth::id())
            ->delete();

        $notification = array(
            'message' => 'Case Deleted Successfully',
            'alert-type' => 'success'
        );

        return response()->json($notification, 200);
    }

    public function ChanageStatus(Request $req, $id)
    {
        $cas = Cas::where('id', $id)
            ->where("user_id", Auth::id())
            ->first();
        $cas->status = $req->status;
        $cas->save();

        $notification = array(
            'message' => 'Status Was Changed Successufuly',
            'alert-type' => 'success',
            'status' => $cas->status
        );
        return response()->json($notification, 200);
    }
}
