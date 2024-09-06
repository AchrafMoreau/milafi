<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $todo = Todo::orderBy('created_at', "ASC")->get();
        return view('todo');
    }

    public function getAll()
    {
        
        $todo = Todo::orderBy('created_at', "ASC")->get();
        return response()->json($todo);
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
        // $request->validate([
        //     "title" => $request->title,
        //     'description' => $request->description,
        //     'dueDate' => $request->dueDate,
        //     'priority' => $request->priority,
        //     'status' => $request->status,
        // ]);
        $request->validate([
            "title" => 'required',
            'dueDate' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);

        $date = date_create($request->dueDate);
        $dateFormat = date_format($date, 'Y-m-d');

        $todo = Todo::create([
            "title" => $request->title,
            'description' => $request->description,
            'dueDate' => $dateFormat,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return response()->json($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
        $date = date_create($request->dueDate);
        $dateFormat = date_format($date, 'Y-m-d');

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->dueDate = $dateFormat;
        $todo->status = $request->status;
        $todo->priority = $request->priority;


        $todo->save();

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
        // dd($todo->id);
        $td = Todo::where('id',$todo->id)->delete();
        return response()->json(['message' => 'Todo Was Deleted Successfuly']);
    }
}
