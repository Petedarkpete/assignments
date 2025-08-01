<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmationController extends Controller
{
    //
    public function confirmTeacher()
    {
        // Logic to view confirmations
        $teachers = DB::table('teachers')
        ->join('users', 'teachers.user_id', '=', 'users.id')
        ->select('teachers.*', 'users.name', 'users.email', 'users.phone')
        ->get();

        return view('confirmations.teachers', compact('teachers'));
    }
}
