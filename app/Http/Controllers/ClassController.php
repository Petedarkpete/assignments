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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    //
    public function index(){
        $classes = Clas::with('streams','teachers', 'users')->get();
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
            Log::info("gets here --1");
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

    public function createClass (){
        return view('class.create');
    }
}
