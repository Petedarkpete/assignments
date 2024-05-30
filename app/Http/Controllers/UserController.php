<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
    public function index(){
        return view('assignments.users');
    }

    public function import(Request $request)
    {
        //validator
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'  // Validate uploaded file
        ]);

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
