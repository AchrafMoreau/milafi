<?php

namespace App\Http\Controllers;

use App\Models\Judge;
use Illuminate\Support\Facades\Auth;
use App\Models\Court;
use Illuminate\Http\Request;

class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $court = Court::All();
        $judges = Judge::with(['court'])->orderBy('created_at', "DESC")->paginate(10);
        return view('dashboard-judges', ['judges' => $judges, 'courts' => $court]);
    }

    public function getAll()
    {
        $judges = Judge::where('user_id', Auth::id())
            ->orWhere('isDefault', 1)
            ->with(['court'])->get();
        return response()->json($judges);
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
        $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'court'=> 'required'
        ]);

        // dd($request);

        $ju = Judge::create([
            "user_id" => Auth::id(),
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'court_id' => $request->court,
            'gender' => $request->gender
        ]);

        $judge = Judge::where('user_id', Auth::id())
            ->with('court')
            ->find($ju->id);

        $notification = array(
            'message' => 'Judge Created successfully',
            'alert-type' => 'success',
            'data' => $judge
        );
        return response()->json($notification, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Judege $judege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Judege $judege)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        
        $request->validate([
            'name' => 'required',
            'contact_info' => 'required',
            'court'=> 'required'
        ]);
        
        $judge = Judge::where('user_id', Auth::id())
            ->findOrFail($id);

        $judge->name = $request->name;
        $judge->gender = $request->gender;
        $judge->contact_info = $request->contact_info;
        $judge->court_id = $request->court;

        $judge->save();

        $juge = Judge::where('user_id', Auth::id())
            ->with('court')
            ->find($judge->id);

        $notification = array(
            'message' => 'Judge Updated successfully',
            'alert-type' => 'success',
            'data' => $juge
        );
        return response()->json($notification, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroyMany(Request $req){
        
        $req->validate([
            'ids' => 'required|array',
        ]);

        $ids = $req->input('ids');
        
        $defaultJudge = Judge::whereIn('id', $ids)
            ->where('isDefault', true)
            ->first();

        if ($defaultJudge) {
            $notification = [
                'message' => 'You cannot delete a default judge',
                'alert-type' => 'error',
            ];

            return response()->json($notification, 403);
        }

        Judge::where('user_id', Auth::id())->whereIn('id', $ids)->delete();

        $notification = array(
            'message' => 'Many Judges Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
    public function destroy(Judge $judege, $id)
    {
        //
        Judge::where('user_id', Auth::id())
            ->find($id)->delete();
        $notification = array(
            'message' => 'Judge Was Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
}
