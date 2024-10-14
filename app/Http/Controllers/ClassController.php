<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MClass;

class ClassController extends Controller
{
    //
    public function index(){
        return view('assignments.class');
    }
    public function add_class(){
        $validator = Validator::make($request->all(), [
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mclass = new MClass;
        $mclass->class = $request->class;
        $mclass->year = $request->year;
        $mclass->user = $request->user;
    }
}
