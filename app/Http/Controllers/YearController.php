<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;

class YearController extends Controller
{
    //
    public function index()
    {
        return view('assignments.year');
    }
    public function add_year(Request $request){
        $user = new Year;
        $user->year = $request->year;
        $user->save();

        return redirect()->back()->with('success', 'User added successfully.');
    }
}
