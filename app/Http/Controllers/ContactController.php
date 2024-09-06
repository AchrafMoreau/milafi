<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contacts = Contact::orderBy('created_at', 'DESC')->get();;
        // dd($contacts);
        // return response()->json($contacts);
        return view('contact', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function getAll()
    {
    
        $contacts = Contact::All();
        return response()->json(['contacts' => $contacts]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd(json_encode($request->tag));
        $cont = Contact::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "tag" => json_encode($request->tag)
        ]);

        $notification = array(
            'message' => 'Contact Created successfully!',
            'alert-type' => 'success'
        );
        // return redirect('/cas')->with($notification);
        return response()->json($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(contact $contact)
    {
        //
        return view('contacts.show-contact', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contact $contact)
    {
        //
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->address = $request->address;
        $contact->tag = json_encode($request->tag);

        $contact->save();
        $notification = array(
            'message' => 'Contact Created successfully!',
            'alert-type' => 'success'
        );
        // return redirect('/cas')->with($notification);
        return response()->json($notification);
        // return response()->json(['message' => 'Contact Was Updated Successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contact $contact)
    {
        //
        $cnt = Contact::where('id',$contact->id)->delete();
        // return response()->json(['message' => 'Contact Was Deleted Successfuly']);
        $notification = array(
            'message' => 'Contact Created successfully!',
            'alert-type' => 'success'
        );
        // return redirect('/cas')->with($notification);
        return response()->json($notification);
    }
}
