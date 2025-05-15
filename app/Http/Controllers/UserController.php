<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use App\Imports\UserImport;
use App\Models\Clas;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('assignments.users', compact('users'));
    }
    public function indextest(){
        $users = User::all();

        return view('assignments.users', compact('users'));
    }
    public function add_parent(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->year = $request->year;
        $user->admission = $request->admission;
        $user->role = $request->role;
        $user->password = Hash::make($password);

        $user->save();

        return redirect()->back()->with('success', 'User added successfully.');

    }

    public function add_user(Request $request){

        $password = rand(000000,999999);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->year = $request->year;
        $user->admission = $request->admission;
        $user->role = $request->role;
        $user->password = Hash::make($password);

        $user->save();

        return redirect()->back()->with('success', 'User added successfully.');
    }
    public function edit_user(Request $request, $id){

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,'
        // ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->year = $request->year;
        $user->admission = $request->admission;
        $user->role = $request->role;

        $user->save();

        return redirect()->back()->with('success_edit', 'User edited successfully.');
    }
    public function delete_user($id){
        $user = User::find($id);

        $user->delete();

        return redirect()->back()->with('success_delete', 'User deleted successfully.');
    }
    public function import(Request $request)
    {
        //validator
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'  // Validate uploaded file
        ]);
        try{
            Excel::import(new UserImport, request()->file('file'));
            return redirect()->back()->with('success', 'Users imported successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'The user already exists!!');
        }

        Excel::import(new UserImport, request()->file('file'));
        // return redirect()->route('users.index')->with('success', 'Users imported successfully.');
        return view('assignments.users');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }
        //for keeping session
        $request->session()->put('user', $user);

        return redirect()->route('users.index');
    }

    public function teachersView () {
        $teachers = Teacher::all();
        return view ('users.teachers.view', compact('teachers'));
    }
    public function teacherCreate () {
        $subjects = Subject::all();
        return view ('users.teachers.create', compact('subjects'));
    }

    public function teacherStore (Request $request) {
        Log::info("Request received for teacher registration.");
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'first_name'       => 'required|string|max:255',
                'last_name'        => 'required|string|max:255',
                'other_names'      => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email|max:255',
                // to change it later to required and numeric
                'phone'            => 'required|numeric|unique:users,phone',
                'gender'           => 'required|in:Male,Female',
                'date_of_birth'    => 'required|date|before:today',
                'address'          => 'required|string|max:255',
                'qualification'    => 'required|string|max:255',
                'specialization'   => 'required|string|max:255',
                'subject_id'       => 'required|exists:subjects,id',
            ]);

            $full_name = $validated['first_name'] . ' ' . $validated['last_name'];
            $password = Str::random(12);
            $hashedPassword = bcrypt($password);

            $user = User::create([
                'name'           => $full_name,
                'first_name'     => $validated['first_name'],
                'last_name'      => $validated['last_name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'gender'         => $validated['gender'],
                'date_of_birth'  => $validated['date_of_birth'],
                'address'        => $validated['address'],
                'password'      => $hashedPassword,
            ]);

            $teacher = Teacher::create([
                'user_id'          => $user->id,
                'qualification'    => $validated['qualification'],
                'specialization'   => $validated['specialization'],
                'join_date'        => now()->toDateString(),
            ]);

            DB::commit();

            return redirect()->route('teachers.view')
                ->with('success', 'Teacher created successfully.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation error: Please fill all required fields correctly.',
            ], 422);
        }

        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Teacher creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while creating teacher.',
            ], 500);
        }
    }

    public function teacherEdit($id)
    {

        $id = Crypt::decryptString($id);
        $user = DB::table('users')->join('teachers', 'teachers.user_id', 'users.id')
            ->select('users.*', 'teachers.*')
            ->where('users.id', $id)
            ->first();
        $subjects = Subject::all();

        return view('users.teachers.edit', compact('user', 'subjects'));

    }

    public function destroyTeacher($id)
    {
        Log::info("gets here");
        try {
            $teacher = User::findOrFail($id);
            $teacher->delete();

            return response()->json(['success' => true, 'message' => 'Teacher deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function studentsView ()
    {
        $students = DB::table('students')
            ->join('users', 'users.id','students.user_id')
            ->join('teachers', 'teachers.id','students.teacher_id')
            ->join('class', 'class.id', 'students.class_id')
            ->join('streams','streams.id','class.stream_id')
            ->join('users as us', 'us.id', 'teachers.user_id')
            ->select('students.id',
                'users.first_name', 'users.last_name', 'users.name',
                'class.label','students.index_number','students.admission_number',
                'students.teacher_id', 'streams.stream', 'users.gender',
                'us.name as tname', 'class.stream_id as cid')
            ->get();
        $teachers = DB::table('teachers')
            ->join('users','users.id','teachers.user_id')
            ->select('teachers.id','users.name')
            ->get();

        $classes = DB::table('class')
            ->join('streams','streams.id','class.stream_id')
            ->join('teachers', 'teachers.id','class.teacher_id')
            ->join('users','users.id','teachers.user_id')
            ->select('class.id','class.label','streams.stream','users.name')
            ->get();

        return view('users.students.view', compact('students','teachers','classes'));

    }

    public function storeStudent (Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'first_name'       => 'required|string|max:255',
                'last_name'        => 'required|string|max:255',
                'gender'           => 'required|in:Male,Female',
                'class_id'         => 'required|exists:class,id',
                'teacher_id'       => 'required|exists:teachers,id',
                'index_number'     => 'required|digits_between:1,6',
                'admission_number' => 'required|string|max:255|unique:students,admission_number',
            ]);


            $full_name = $validated['first_name'] . ' ' . $validated['last_name'];
            $password = Str::random(12);
            $hashedPassword = bcrypt($password);

            $user = User::create([
                'name'           => $full_name,
                'first_name'     => $validated['first_name'],
                'last_name'      => $validated['last_name'],
                'gender'         => $validated['gender'],
                'password'       => $hashedPassword,
            ]);

            $students = Student::create([
                'user_id'          => $user->id,
                'index_number'         => $validated['index_number'],
                'admission_number'     => $validated['admission_number'],
                'teacher_id'       => $validated['teacher_id'],
                'class_id'         => $validated['class_id'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully.',
            ]);


        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation error: Please fill all required fields correctly.',
            ], 422);
        }

        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while creating student.',
            ], 500);
        }

    }

    public function updateStudent(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'gender'           => 'required|in:Male,Female',
            'class_id'         => 'required|exists:class,id',
            'teacher_id'       => 'required|exists:teachers,id',
            'index_number'     => 'required|digits_between:1,6',
            'admission_number' => 'required|string|max:255|',
        ]);

        DB::beginTransaction();
        try {

            $student = Student::findOrFail($id);

            $student->update([
                'class_id'          => $validated['class_id'],
                'teacher_id'        => $validated['teacher_id'],
                'index_number'      => $validated['index_number'],
                'admission_number'  => $validated['admission_number'],
            ]);

            $user = $student->user;
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'name'       => $validated['first_name'] . ' ' . $validated['last_name'],
                'gender'     => $validated['gender'],
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully.'
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation error: Please fill all required fields correctly.',
            ], 422);
        }

        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student editing failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while editing student.',
            ], 500);
        }

    }
    public function destroyStudent($id)
    {
        try {
            Log::info("Gets here.");
            $subject = Student::findOrFail($id);
            $subject->delete();

            return response()->json(['success' => true, 'message' => 'Student deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    public function importStudents(Request $request)
    {
        Log::info("the template". $request->all());
        dd();
        try{
            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'class_id'   => 'required|exists:class,id',
                'excel_file' => 'required|mimes:xlsx,xls',
            ]);

            Excel::import(new StudentsImport($request->teacher_id, $request->class_id), $request->file('excel_file'));

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully.'
            ]);

        }catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation error: Please fill all required fields correctly.',
            ], 422);
        }

        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student editing failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while editing student.',
            ], 500);
        }


    }
}
