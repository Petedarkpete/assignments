<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    //
    public function index (){
        $subjects = Subject::all();
        return view ('subject.view', compact('subjects'));
    }

    public function createSubject (){
        return view('subject.create');
    }
    public function store (Request $request) {

        try {
            $validated = $request->validate([
                'name'   => 'required|string|max:255',
                'code'   => 'required|string|max:50|unique:subjects,code',
                'status' => 'required|boolean',
            ]);


            Log::info("Validation passed for subject: ", $validated);

            Subject::create($validated);

            $subjects = Subject::all();

            $html = view('subject.view', compact('subjects'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Subject created successfully.',
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return response()->json(['success' => true, 'message' => 'Subject deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
