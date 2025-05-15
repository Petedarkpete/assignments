<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Classroom;
use App\Models\MClass;
use App\Models\Stream;
use App\Models\Teacher;
use App\Models\Year;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    //
    public function index(){
        $classes = DB::table('class')
            ->join('teachers', 'teachers.id','class.teacher_id')
            ->join('streams', 'streams.id','class.stream_id')
            ->join('users', 'users.id', 'teachers.user_id')
            ->select('class.id','streams.stream', 'streams.id as str_id', 'class.label', 'users.name','class.status', 'teachers.id as tr_id')
            ->get();

        //this should change, it is for testing
        $teachers = Teacher::with('user')->get();
        $streams = Stream::all();
        return view('class.view', compact('classes','teachers','streams'));
    }
    public function add_class(Request $request){

        $validator = Validator::make($request->all(), [
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mclass = new Classroom;
        $mclass->class = $request->class;
        $mclass->year = $request->year;
        $mclass->user = $request->user;

        $mclass->save();

        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function store(Request $request){

        try {
            //code...
            $validated = $request->validate([
                'stream_id' => 'required|exists:streams,id',
                'label' => 'required|string|max:255',
                'teacher_id' => 'nullable|exists:users,id',
                'status' => 'required|boolean',
            ]);
            Log::info("the validated ". json_encode($validated));


            Clas::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Class created successfully.'
            ]);

        }  catch (ValidationException $e) {
            Log::info("gets here --2");
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $e->validator->errors()->toArray()
            ], 422);

        } catch (\Exception $e) {
            Log::info("gets here --3");
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update (Request $request, $id)
    {
        try {
            Log::info("the id  ". json_encode($request->all()));
            $validated = $request->validate([
                'stream' => 'required|exists:streams,id',
                'label' => 'required|string|max:255',
                'teacher_id' => 'nullable|exists:users,id',
                'status' => 'required|boolean',
            ]);

            $class = Clas::findOrFail($id);
            $class->update($request->only('stream','label','teacher_id','status'));

            return response()->json([
                'success' => true,
                'message' => 'Class updated successfully.'
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
                'message' => 'An error occurred while updating the class.',
                'error' => $e->getMessage()
            ], 500); // Use 500 for Internal Server Error
        }
    }

    public function destroy($id)
    {
        try {
            $subject = Clas::findOrFail($id);
            $subject->delete();

            return response()->json(['success' => true, 'message' => 'Subject deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function createClass (){
        return view('class.create');
    }
}
