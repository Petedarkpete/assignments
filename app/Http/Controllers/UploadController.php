<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //for showing page
    public function index()
    {
        return view('assignments.upload');
    }
    public function upload(Request $request)
    {
        $id = $request->id;
        
        // $file = $request->file('file');
        // $filename = $file->getClientOriginalName();
        // $file->move(public_path('uploads'), $filename);
        // return response()->json([
        //     'message' => 'File uploaded successfully',
        //     'file' => $filename
        // ]);

    }
}
