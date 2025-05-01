<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use App\Models\Subject;
use App\Models\Teacher;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
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
                'is_class_teacher' => 'required|numeric'
            ]);

            $full_name = $validated['first_name'] . ' ' . $validated['last_name'];
            $password = Str::random(12);
            $hashedPassword = bcrypt($password);

            $is_class_teacher = 1;

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
                'is_class_teacher' => $validated['is_class_teacher'],
                'join_date'        => now()->toDateString(),
            ]);

            DB::commit();

            return redirect()->route('teachers.view')
                ->with('success', 'Teacher created successfully.');

        } catch (ValidationException $e) {
            DB::rollBack();

            return redirect()->route('teachers.view')
                ->with('success', 'Validation error: Kindly Fill all the fields');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Teacher creation failed: ' . $e->getMessage());

            return redirect()->route('teachers.view')
                ->with('success', 'An error occurred when creating teacher');
        }
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
}
