<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YearController extends Controller
{
    //
    public function index()
    {
        return view('assignments.year');
    }
}
