<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\UploadedAssignment;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class UploadController extends Controller
{
    //for showing page
    public function index()
    {
        //$assignments = UploadedAssignment::where('user_id', Auth::id())->get();
        $assignments = UploadedAssignment::all();
        return view('assignments.upload_ass',compact('assignments'));
    }

    public function createAssignmentView()
    {
        $teacherId = FacadesSession::get('id');
        $teacher = Teacher::where('user_id', $teacherId)->first();

        $subjects = Subject::all();
        $classes = Clas::all();

        return view('assignments.create', compact('teacher','subjects','classes'));
    }
    public function createAssignment(Request $request)
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

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'external_link' => 'nullable|url',
            'due_date' => 'required|date',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

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

        return redirect()->back()->with('success', 'Assignment created successfully');
    }
    public function destroy($id)
    {
        $assignment = UploadedAssignment::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully');
    }
    public function show($id)
    {
        $assignment = UploadedAssignment::findOrFail($id);
        return view('assignments.show', compact('assignment'));
    }
    public function download($id)
    {
        $assignment = UploadedAssignment::findOrFail($id);
        $filePath = public_path($assignment->file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
    public function edit($id)
    {
        $assignment = UploadedAssignment::findOrFail($id);
        return view('assignments.edit', compact('assignment'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'deadline' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Adjust file types and size as needed
        ]);

        $assignment = UploadedAssignment::findOrFail($id);
        $assignment->year = $request->year;
        $assignment->course = $request->course;
        $assignment->deadline = $request->deadline;
        $assignment->title = $request->title;
        $assignment->details = $request->description;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $destination = public_path('uploads/assignments');
            $file->move($destination, $filename);

            $assignment->file = 'uploads/assignments/' . $filename;
        }

        $assignment->save();

        return redirect()->back()->with('success', 'Assignment updated successfully');
    }
}
