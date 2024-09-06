<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TemporaryFiles;


class uplaodContnroller extends Controller
{
    //
    public function store(Request $req){

        if($req->hasFile('docs')){
            $file = $req->file('docs');
            $fileName = $file->getClientOriginalName();
            $folder = Auth::user()->id . '-' . now()->timestamp;
            $filepath = $file->storeAs('uploads/'. $folder, $fileName, 'public');

            TemporaryFiles::create([
                "filename" => $fileName,
                'folder' => $folder
            ]);
            return $folder;
        }

        return '';
    }
}
