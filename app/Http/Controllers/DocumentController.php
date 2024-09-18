<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Cas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TemporaryFiles;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cases = Cas::All();
        $docs =  Document::with('cas')->orderBy('created_at', 'DESC')->Paginate(10);
        // return response()->json($docs);
        return view('dashboard-documnet', ['docs' => $docs, 'cases' => $cases]);
    }

    public function getAll()
    {
        $docs = Document::with('cas')->get();
        return response()->json($docs);
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
        // dd($request, $request->file('docs'));
        $do;
        $request->validate([
            'name' => 'required',
            'case' => 'required',
        ]);


        $doc = TemporaryFiles::where("folder", $request->docs)->first();
        if($doc){
            $filepath = storage_path('app/public/uploads/' . $request->docs . '/' . $doc->filename);
            // dd($file);
            // $filename = $file->name;
            // $file->storeAs('uploads', $filename, 'public');
            $do = Document::create([
                'name' => $request->name,
                'cas_id' => $request->case,
                'file_desc' => $request->file_desc,
                'user_id' => Auth::user()->id,
                'file_path' => $doc->folder . '/' . $doc->filename,
            ]);

     

        }else{
            $do = Document::create([
                'name' => $request->name,
                'cas_id' => $request->case,
                'file_desc' => $request->file_desc,
                'user_id' => Auth::user()->id
            ]);
        }

        // dd($d);
        $document = Document::with('cas')->find($do->id);
        $notification = array(
            'message' => 'Documents Created successfully',
            'alert-type' => 'success',
            'data' => $document
        );
        return response()->json($notification);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $doc = Document::findOrFail($id);
        return view('documents.view-document', ['doc' => $doc]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
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
            'case' => 'required',
        ]);

        $oldDocument = Document::findorFail($id);
        $doc = TemporaryFiles::where("folder", $request->docs)->first();

        if($doc){
            $filepath = storage_path('app/public/uploads/' . $request->docs . '/' . $doc->filename);
           

            // dd($request->docs);
            // unlink($filepath);
            // rmdir(storage_path('app/public/uploads/' . $request->docs));
            $files = $request->file('docs');
           
            $oldDocument->name = $request->name;
            $oldDocument->cas_id = $request->case;
            $oldDocument->file_desc = $request->file_desc;
            $oldDocument->file_path = $doc->folder . '/' . $doc->filename;

            $oldDocument->save();

        }else{
            $oldDocument->name = $request->name;
            $oldDocument->file_desc = $request->file_desc;
            $oldDocument->cas_id = $request->case;

            $oldDocument->save();
        }

        $document = Document::with('cas')->find($oldDocument->id);

        $notification = array(
            'message' => 'Documents Update successfully',
            'alert-type' => 'success',
            'data' => $document
        );
        return response()->json($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Document::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Documents Deleted successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }

    public function destroyMany(Request $req){
        
        $req->validate([
            'ids' => 'required|array',
        ]);
        
        // return 'hello';

        $da = Document::whereIn('id', $req->input('ids'))->delete();
        $notification = array(
            'message' => 'Many Judges Deleted Successfully',
            'alert-type' => 'success'
        );
        return response()->json($notification);
    }
    public function downloadFile($folder, $filename){

        // dd($filename, $folder);
         $filePath = storage_path('app/public/uploads/' . $folder . '/' . $filename);

        // Check if the file exists
        // dd($filePath);
        if (!file_exists($filePath)) {
            $notification = array(
                'message' => 'Documents Was Not Found !',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }



        // Download the file
        return response()->download($filePath);
    }
}
