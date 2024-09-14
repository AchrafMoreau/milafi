<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Cas;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clients = Client::with('cas')->orderBy('created_at' , 'DESC')->Paginate(10);
        // $clients = Client::Paginate(10);
        return view('dashboard-clients', ["clients" => $clients]);
        // return response()->json($clients);
    }

    public function getAll()
    {
        $clients = Client::with('cas')->get();
        return response()->json($clients, 200);
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
        // return "hello  world";
        $request->validate([
            'name' => ['required', 'max:255'],
            'contact_info' => 'string',
            'gender' => 'string',
            'CIN' => ['required','string', 'unique:clients']
        ]);

        // dd($request);

        // this code should be on the blade  for case selected the new client ----------------------------------------
        // @if($clientSelected)
        //     <option selected value="{{ $clientSelected->id }}">{{ $clientSelected->name }}</option>
        // @endif 
        // this code should be on the blade ----------------------------------------
        // dd($request);

        $cl = Client::create([
            'name' => $request->name,
            'avatar' => $request->avatar,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'gender' => $request->gender,
            'CIN' => $request->CIN
        ]);

        // dd($cl);
        $notification = array(
            'message' => 'Client Created successfully!',
            'alert-type' => 'success',
            'data' => $cl
        );
        return response()->json($notification, 201);
        // return response()->json(['success'=> "Client Created Successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $cl = Client::with('cas')->findOrFail($id);
        return view('clients.show-client', ['client' => $cl]);
        // return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $client)
    {
        //
        $oldClient = Client::find($client);
        $request->validate([
            'name' => ['required', 'max:255'],
            'contact_info' => 'string',
            'gender' => 'string',
            'CIN' => [
                'required', 
                Rule::unique('clients')->ignore($oldClient->id)
            ]
        ]);



        $oldClient->name = $request->input('name');
        $oldClient->address = $request->input('address');
        $oldClient->gender = $request->input('gender');
        $oldClient->contact_info = $request->input('contact_info');
        $oldClient->CIN = $request->input('CIN');

        $oldClient->save();
        
        // return response()->json(["message" => 'Client Was Updated Successfully']);
        $notification = array(
            'message' => 'Client Updated successfully!',
            'alert-type' => 'success',
            'data' => $oldClient
        );
        return response()->json($notification, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMany(Request $req){

        $req->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:clients,id'
        ]);

        Client::destroy($req->input('ids'));
        $notification = array(
            'message' => 'Many Client Deleted successfully!',
            'alert-type' => 'success'
        );
        return response()->json($notification, 200);
    }
    public function destroy(Client $client)
    {
        //
        // dd($client);
        Client::where('id', $client->id)->delete();
        $notification = array(
            'message' => 'Client Deleted successfully!',
            'alert-type' => 'success'
        );
        // return response()->json($notification);
        return response()->json($notification, 200);
    }
}
