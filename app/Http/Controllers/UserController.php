<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        return view('assignments.users');
    }

    public function add_bulk(){
        
    }
}