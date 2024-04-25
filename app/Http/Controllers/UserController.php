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
        Excel::import(new UserImport, request()->file('file'));
        return redirect()->route('users.index')->with('success', 'Users imported successfully.');
    }
}
