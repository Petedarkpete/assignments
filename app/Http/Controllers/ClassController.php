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

use function Illuminate\Log\log;

class ClassController extends Controller
{
    //
    public function index(){
        $classes = DB::table('class')
            ->leftJoin('teachers', 'teachers.id','class.teacher_id')
            ->join('streams', 'streams.id','class.stream_id')
            ->leftJoin('users', 'users.id', 'teachers.user_id')
            ->select('class.id','streams.stream', 'streams.id as str_id', 'class.label', 'users.name','class.status', 'teachers.id as tr_id')
            ->get();

        //this should change, it is for testing
        $teachers = Teacher::with('user')
            ->whereNotIn('id', function ($query) {
                $query->select('teacher_id')->from('class')->whereNotNull('teacher_id');
            })
            ->get();

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
                'teacher_id' => 'nullable|exists:teachers,id',
                'status' => 'required|boolean',
            ]);
            Log::info("the validated ". json_encode($validated));

            $existingClass = Clas::where('stream_id', $validated['stream_id'])
                ->where('label', $validated['label'])
                ->first();

            Log::info("the existing class ". json_encode($existingClass));

            if ($existingClass) {
                return response()->json([
                    'success' => false,
                    'message' => 'A class with this label already exists in the selected stream.'
                ], 422);
            }


            Clas::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Class created successfully.'
            ]);

        }  catch (ValidationException $e) {
            Log::info("gets here --2");

            $validationErrors = $e->validator->errors()->toArray();

            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $validationErrors
            ], 422);
        }
         catch (\Exception $e) {
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

            Log::info("the requests  ". json_encode($request->all()));

            $validated = $request->validate([
                'stream' => 'required|exists:streams,id',
                'label' => 'required|string|max:255',
                'teacher_id' => 'nullable|exists:teachers,id',
                'status' => 'required|boolean',
            ]);

            Log::info("the validated ". json_encode($validated));
            $class = Clas::findOrFail($id);
            Log::info(" the class " .json_encode($class));
            $class->update($request->only('stream_id', 'label', 'teacher_id', 'status'));

            return response()->json([
                'success' => true,
                'message' => 'Class updated successfully.'
            ]);
        } catch (ValidationException $e) {

            Log::warning('Validation error while updating the class', [
                'errors' => $e->validator->errors()->toArray()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $e->validator->errors()->toArray()
            ], 422);

       } catch (\Exception $e) {
        Log::error('Error while updating the class', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the class.',
                'error' => $e->getMessage()
            ], 500);
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

    public function checkClass(Request $request)
    {
        Log::info("the request ". json_encode($request->all()));
        try {
                $validated = $request->validate([
                    'stream' => 'required|exists:streams,id',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error("Validation failed: " . json_encode($e->errors()));
                throw $e; // re-throw or handle accordingly
            }

        $usedLabels = Clas::where('stream_id', $validated['stream'])->pluck('label')->toArray();

        $allLabels = ['West', 'East', 'North', 'South', 'Central'];

        $available = array_diff($allLabels, $usedLabels);

        return response()->json([
                'labels' => array_values($available)
            ]);
    }

}
