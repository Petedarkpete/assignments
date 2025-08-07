<?php

namespace App\Http\Controllers;

use App\Jobs\SendAssignmentNotificationJob;
use App\Jobs\SendTeacherConfirmationEmail;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        Log::info("Viewing confirmation for teacher with ID: $id");
        $teachers = DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('teachers.*', 'users.*')
            ->where('users.confirmed', 0)
            ->where('teachers.id', $id)
            ->get();

        return view('confirmations.teachers.confirm', compact('teachers'));
    }

    public function confirmTeacherAction($id)
    {

        Log::info("Confirming teacher with ID: $id");
        $teacher = User::findOrFail($id);
        $teacher->confirmed = 1; // Assuming 'confirmed' is a field in the users table
        $teacher->save();

        if ($teacher->save()) {
            // Send activation email
            // Dispatch the job to send confirmation email
            SendTeacherConfirmationEmail::dispatch($teacher);
        }

        return redirect()->route('confirmations.teachers.view')->with('success', 'Teacher confirmed successfully.');
    }

    public function test($id)
    {
        Log::info("Confirming teacher with IDss: $id");
        $teacher = DB::table('teachers')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('teachers.*', 'users.name', 'users.email', 'users.phone')
            ->where('users.id', $id)
            ->first();

        if (!$teacher) {
            Log::error("Teacher not found with ID: $id");
            return redirect()->back()->with('error', 'Teacher not found.');
        }
        $activation_token = Str::random(60);

        $updated = DB::table('users')->where('id', $teacher->user_id)->update([
            'activation_token' => $activation_token,
            'confirmed' => 1,
            'activation_token_expires_at' => now()->addMinutes(5)
        ]);

        if ($updated) {
            $teacher->activation_token = $activation_token;
            $teacher->activation_token_expires_at = now()->addMinutes(5);

            Log::info("Dispatching SendTeacherConfirmationEmail for teacher ID: $id");
            SendTeacherConfirmationEmail::dispatch($teacher);
        } else {

            Log::error("Failed to confirm teacher with ID: $id");
            return redirect()->back()->with('error', 'Failed to confirm teacher, contact support.');
        }

        return redirect()->route('confirmTeachers.view')->with('success', 'Teacher confirmed successfully.');

    }

    public function confirmAssignment()
    {
        // Logic to view assignment confirmations
        $assignments = DB::table('uploaded_assignments')
            ->leftJoin('users', 'uploaded_assignments.teacher_id', '=', 'users.id')
            ->select('uploaded_assignments.*', 'users.name', 'users.email', 'users.phone')
            ->whereNull('uploaded_assignments.confirmed')
            ->get();

        return view('confirmations.assignments.view', compact('assignments'));
    }

    public function confirmAssignmentView($id)
    {
        // Logic to view confirmation page for assignments
        Log::info("Viewing confirmation for assignment with ID: $id");
        $assignments = DB::table('uploaded_assignments')
            ->leftJoin('users', 'uploaded_assignments.teacher_id', '=', 'users.id')
            ->select('uploaded_assignments.*', 'users.name', 'users.email', 'users.phone')
            ->where('uploaded_assignments.id', $id)
            ->get();

        return view('confirmations.assignments.confirm', compact('assignments'));
    }

    public function confirmAssignmentAction($id)
    {
        Log::info("Confirming assignment with ID: $id");
        $assignment = DB::table('uploaded_assignments')->where('id', $id)->first();

        if (!$assignment) {
            Log::error("Assignment not found with ID: $id");
            return redirect()->back()->with('error', 'Assignment not found.');
        }

        // Update the assignment as confirmed
        DB::table('uploaded_assignments')->where('id', $id)->update(['confirmed' => 1]);
        $parents = DB::table('parents')
        ->join('students', 'students.parent_id', '=', 'parents.id')
        ->where('students.class_id', $assignment->class_id) // Or any relation you use
        ->select('parents.*')
        ->get();

        foreach ($parents as $parent) {
            // Dispatch the job to send assignment notification email
            SendAssignmentNotificationJob::dispatch($assignment, $parent->email);
        }


        return redirect()->route('confirmations.assignments.view')->with('success', 'Assignment confirmed successfully.');
    }
}
