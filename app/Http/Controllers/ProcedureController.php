<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedure;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
        //
        // dd($request);
        $request->validate([
            'date' => ['required'],
            'time' => ['required'],
            'procedure' => ['required', 'string'],
            'fee' => ['required'],
            'invoice' => ['required'],
        ]);

        $proc = Procedure::create([
            'date' => $request->date,
            'procedure' => $request->procedure,
            'time' => $request->time,
            'fee' => $request->fee,
            'invoice' => $request->invoice,
            'cas_id' => $id
        ]);

        $notification = array(
            'message' => 'Procedure Was Created Successufuly',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification)->withHeaders([
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Procedure $judege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procedure $judege)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procedure $judege)
    {
        //
    }
}
