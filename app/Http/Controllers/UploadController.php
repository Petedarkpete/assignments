<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\UploadedAssignment;
use Illuminate\Container\Attributes\DB;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    //for showing page
    public function index()
    {
        //$assignments = UploadedAssignment::where('user_id', Auth::id())->get();
        $assignments = UploadedAssignment::all();
        return view('assignments.view',compact('assignments'));
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'external_link' => 'nullable|url',
                'due_date' => 'required|date',
                //this will be changed to teacher later
                'user_id' => 'required|exists:teachers,user_id',
                'class_id' => 'required|exists:class,id',
                'subject_id' => 'required|exists:subjects,id'
            ]);

            Log::info('Creating assignment with data: ' . json_encode($validated));

            $teacher_id = Teacher::where('user_id', $validated['user_id'])->value('id');

            FacadesDB::beginTransaction();

            $assignment = new UploadedAssignment();
            $assignment->title = $validated['title'];
            $assignment->description = $validated['description'] ?? '';
            $assignment->file_path = $validated['file_path'] ?? null;
            $assignment->external_link = $validated['external_link'] ?? null;
            $assignment->due_date = $validated['due_date'];
            $assignment->teacher_id = $teacher_id;
            $assignment->class_id = $validated['class_id'];
            $assignment->subject_id = $validated['subject_id'];

            // File upload
            if ($request->hasFile('file')) {
                try {
                    $file = $request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $destination = public_path('uploads/assignments');

                    if (!file_exists($destination)) {
                        mkdir($destination, 0755, true);
                    }

                    $file->move($destination, $filename);
                    $assignment->file = 'uploads/assignments/' . $filename;

                } catch (\Exception $fileEx) {
                    FacadesDB::rollBack();
                    Log::error('File upload failed: ' . $fileEx->getMessage());
                    return back()->withErrors(['file' => 'File upload failed.']);
                }
            }

            $assignment->save();
            FacadesDB::commit();

            return redirect()->route('assignments.index')->with('success', 'Assignment uploaded successfully.');
        } catch (\Exception $e) {
            FacadesDB::rollBack();
            Log::error('Assignment creation failed: ' . $e->getMessage());

            return redirect()->route('assignments.index')->withErrors(['error' => 'Error occured while uploading the assignment.']);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));

            FacadesDB::rollBack();
            return redirect()->route('assignments.index')->withErrors(['error' => 'Validation failed. Please check your inputs.']);
        }
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
    public function editAssignment($id)
    {
        $assignment = UploadedAssignment::findOrFail($id);
        return view('assignments.edit', compact('assignment'));
    }
    public function updateAssignment(Request $request, $id)
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
