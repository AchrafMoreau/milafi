<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = ['cassation', 'appel', 'première instance', 'Centres des juges résidents', 'appel de commerce', 'commerciaux', 'appel administratives', 'administratifs'];
        $courts = Court::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(10);
        return view('dashboard-court', ['courts' => $courts, 'categories' => $category]);
    }

    public function getAll()
    {
        $courts = Court::where('user_id', Auth::id())
            ->orWhere('isDefault', 1)
            ->get();
        return response()->json($courts);
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
            'location' => 'required',
            'category' => 'required',
        ]);

        $court = Court::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'location' => $request->location,
            'category' => $request->category,
        ]);


        $notification = array(
            'message' => 'Court Created successfully',
            'alert-type' => 'success',
            'data' => $court
        );
        return response()->json($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Court $court)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Court $court)
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
            'location' => 'required',
            'category' => 'required',
        ]);
        
        $court = Court::where("user_id", Auth::id())->findOrFail($id);

        $court->name = $request->name;
        $court->location = $request->location;
        $court->category = $request->category;

        $court->save();

        $notification = array(
            'message' => 'Court Update successfully',
            'alert-type' => 'success',
            'data' => $court
        );
        return response()->json($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMany(Request $req){
        
        $req->validate([
            'ids' => 'required|array',
        ]);
        
        // return 'hello';

        Court::where('user_id', Auth::id())->destroy($req->input('ids'));
        $notification = array(
            'message' => 'Many Courts Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
    public function destroy(Court $court, $id)
    {
        //
        Court::where('user_id', Auth::id())->find($id)->delete();
        $notification = array(
            'message' => 'Court Deleted successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
}
