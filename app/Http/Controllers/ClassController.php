<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Classroom;
use App\Models\Year;
use App\Models\User;

class ClassController extends Controller
{
    //
    public function index(){
        $grades = Year::all();
        $teachers = User::where('role',2)->get();
        return view('assignments.class', compact('grades','teachers'));
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
}
