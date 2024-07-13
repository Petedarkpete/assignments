<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class UploadController extends Controller
{
    //for showing page
    public function index()
    {
        return view('assignments.upload');
    }
    public function upload(Request $request)
    {
        $assignment = new Assignment;
        $assignment->year = $request->year;
        $assignment->course = $request->course;
        $assignment->deadline = $request->deadline;
        $assignment->title = $request->title;
        $assignment->description = $request->description;

        
        // $file = $request->file('file');
        // $filename = $file->getClientOriginalName();
        // $file->move(public_path('uploads'), $filename);
        // return response()->json([
        //     'message' => 'File uploaded successfully',
        //     'file' => $filename
        // ]);
        
        $assignment->save();

    }
}
