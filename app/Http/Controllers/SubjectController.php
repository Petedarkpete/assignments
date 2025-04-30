<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //
    public function index (){
        return view ('subject.view');
    }

    public function createSubject (){
        return view('subject.create');
    }
    public function store (Request $request) {

    }
}
