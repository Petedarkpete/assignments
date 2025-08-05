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
        ->where('users.confirmed', 0)
        ->get();

        return view('confirmations.teachers.view', compact('teachers'));
    }

    public function confirmTeacherView($id)
    {
        // Logic to view confirmation page
        $teachers = DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('teachers.*', 'users.name', 'users.email', 'users.phone')
            ->where('users.confirmed', 0)
            ->where('teachers.id', $id)
            ->get();

        return view('confirmations.teachers.confirm', compact('teachers'));
    }

    public function confirmTeacherAction($id)
    {
        // Logic to confirm a teacher
        $teacher = Teacher::findOrFail($id);
        $teacher->confirmed = 1; // Assuming 'confirmed' is a field in the teachers table
        $teacher->save();

        return redirect()->route('teachers.view')->with('success', 'Teacher confirmed successfully.');
    }
}
