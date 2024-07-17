<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadedAssignment;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    //for showing page
    public function index()
    {
        //$assignments = UploadedAssignment::where('user_id', Auth::id())->get();
        $assignments = UploadedAssignment::all();
        return view('assignments.upload',compact('assignments'));
    }
    public function upload(Request $request)
    {
        $assignment = new UploadedAssignment;
        $assignment->year = $request->year;
        $assignment->course = $request->course;
        $assignment->deadline = $request->deadline;
        $assignment->title = $request->title;
        $assignment->details = $request->description;
        $assignment->user_id = Auth::id();

        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destination = public_path('uploads/assignments');
            $file->move($destination, $filename);
    
            $assignment->file = 'uploads/assignments/' . $filename;
        }
    
        
        $assignment->save();

        return redirect()->back()->with('success', 'Assignment uploaded successfully');

    }
}
