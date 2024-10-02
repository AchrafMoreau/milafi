<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        // return response()->json(['users' => $contacts]);
        return view('users', ['users' => $users]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'city' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'arabName'=> ['required', 'string'],
            'arabCity' => ['required', 'string'],
            'role' => ['required', 'in:Admin,Lawyer,Assistant,SuperAdmin']
        ]);
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'city' => $request->city,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'name_in_arab' => $request->arabName,
            'city_in_arab' => $request->arabCity,
            'role' => $request->role
        ]);

        // dd($user);

        $notification = array(
            'message' => 'User Was Created Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::find($id)->delete();
        $notification = array(
            'message' => 'User Was Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
}
