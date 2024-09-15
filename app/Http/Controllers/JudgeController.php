<?php

namespace App\Http\Controllers;

use App\Models\Judge;
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
            'gender' => 'required',
            'contact_info' => 'required',
            'court'=> 'required'
        ]);

        $judge = Judge::create([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'court_id' => $request->court,
            'gender' => $request->gender
        ]);


        $notification = array(
            'message' => 'Judge Created successfully!',
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
            'gender' => 'required',
            'contact_info' => 'required',
            'court'=> 'required'
        ]);
        
        $judge = Judge::findOrFail($id);

        $judge->name = $request->name;
        $judge->gender = $request->gender;
        $judge->contact_info = $request->contact_info;
        $judge->court_id = $request->court;

        $judge->save();

        $notification = array(
            'message' => 'Judge Updated successfully!',
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
        
        // return 'hello';

        Judge::destroy($req->input('ids'));
        $notification = array(
            'message' => 'Many Judges Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function destroy(Judge $judege, $id)
    {
        //
        Judge::find($id)->delete();
        $notification = array(
            'message' => 'Judge Was Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
