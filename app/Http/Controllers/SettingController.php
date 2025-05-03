<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    //
    public function index (){
        $streams = Stream::with('teacher.user')->get();
        $teachers = Teacher::with('user')->get();
        return view ('settings.streams', compact('streams','teachers'));
    }
    public function store (Request $request) {

        try {
            $validated = $request->validate([
                'stream'   => 'required|string|max:255',
                //will add teachers rep later
                'teacher_id' => 'required|exists:teachers,id',
                'status' => 'required|boolean',
            ]);


            Log::info("Validation passed for stream: ", $validated);

            Stream::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Stream created successfully.'
            ]);
        } catch (\Exception $e) {
            Log::info("the error-- ".$e->getMessage() );

            return response()->json([
                'success' => false,
                'message' => 'Error adding subject'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'stream'   => 'required|string|max:255',
                //will add teachers rep later
                'teacher_id' => 'required|exists:teachers,id',
                'status' => 'required|boolean',
            ]);

            $subject = Stream::findOrFail($id);
            $subject->update($request->only('stream', 'teacher_id', 'status'));

            return response()->json([
                'success' => true,
                'message' => 'Stream updated successfully.'
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation error. Kindly Recheck the fields',
                'errors' => $e->validator->errors()->toArray()
            ], 422);


        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the stream.',
                'error' => $e->getMessage()
            ], 500); // Use 500 for Internal Server Error
        }
    }
    public function destroy($id)
    {
        try {
            $subject = Stream::findOrFail($id);
            $subject->delete();

            return response()->json(['success' => true, 'message' => 'Subject deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
