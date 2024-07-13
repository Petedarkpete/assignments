<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


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
}
