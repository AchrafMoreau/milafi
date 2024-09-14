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
        $cases = Cas::with(['client', 'court', 'judge'])->get();
        return response()->json($cases, 200);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $clients = Client::All();
        $courts = Court::All();
        $judge = Judge::All();
        return view('cases.add-cas', ['courts' => $courts, 'judges' => $judge, 'clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        //
        
        // dd($req->date && $req->desc && $req->invoice && $req->fee);
        $cas = Cas::create([
            'user_id' => Auth::user()->id,
            'serial_number' => $req->serial_number,
            'court_id'=> $req->court,
            'client_id' => $req->client,
            'title_file' => $req->file_subject,
            'title_number' => $req->title_number,
            'judge_id' => $req->judge,
            'report_file' => $req->report_file,
            'execution_file' => $req->execution_file,
            'report_number' => $req->report_number,
            'execution_number' => $req->execution_number,
            'opponent' => $req->opponent,
            'status' => 'Open',
        ]);

         if($req->date && $req->procedure && $req->invoice && $req->fee && $req->time){
            Procedure::create([
                'cas_id' => $cas->id,
                'time' => $req->time,
                'date' => $req->date,
                'procedure' => $req->procedure,
                'invoice' => $req->invoice,
                'fee' => $req->fee
            ]);
        }

        $notification = array(
            'message' => 'Case Created successfully!',
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
        $clients = Client::All();
        $docs = Document::where('cas_id', $case)->first();
        $ca = Cas::with(['client', 'court', 'judge', 'document'])->find($case);
        // return response()->json($ca);
        return view('cases.show-cas', ['case' => $ca]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $clients = Client::All();
        $court = Court::All();
        // $proc = Procedure::find('cas_id', $id);
        $judge = Judge::All();
        $cas = Cas::with(['client', 'court', 'judge', 'document', 'procedure'])->find($id);
        // dd($cas);
        // return response()->json($cas);
        return view('cases.edit-cas', ['case' => $cas, 'clients' => $clients, 'judges' => $judge, 'court' => $court]);

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


        $cas = Cas::findOrFail($id);
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
            'message' => 'Case Updated successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMany(Request $req){
        


        // dd($req);
        $req->validate([
            'ids' => 'required|array',
        ]);
        
        // return 'hello';

        $da = Cas::whereIn('serial_number', $req->input('ids'))->delete();
        $notification = array(
            'message' => 'Many Cases Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
    public function destroy($id)
    {
        //
        Cas::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Case Deleted Successfully',
            'alert-type' => 'success'
        );

        return response()->json($notification, 200);
    }

    public function ChanageStatus(Request $req, $id)
    {
        $cas = Cas::where('id', $id)->first();
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
