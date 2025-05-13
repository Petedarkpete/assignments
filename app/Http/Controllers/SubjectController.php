<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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

            return response()->json([
                'success' => true,
                'message' => 'Subject created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50',
                'status' => 'required|boolean',
            ]);

            $subject = Subject::findOrFail($id);
            $subject->update($request->only('name', 'code', 'status'));

            return response()->json([
                'success' => true,
                'message' => 'Subject updated successfully.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $e->validator->errors()->toArray()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the subject.',
                'error' => $e->getMessage()
            ], 500); // Use 500 for Internal Server Error
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
