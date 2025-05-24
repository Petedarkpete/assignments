<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function findTeacher($id)
    {
        $teachers = DB::table('class')
            ->join('teachers', 'teachers.id', '=', 'class.teacher_id')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->select('users.name', 'teachers.id')
            ->where('class.id', $id)
            ->first();

        return response()->json($teachers);
    }

    public function findStudent(Request $request)
    {
        $admissionNo = $request->query('admission_no');

        $student = DB::table('students')
            ->join('teachers', 'teachers.id', '=', 'students.teacher_id')
            ->join('class', 'class.id', '=', 'students.class_id')
            ->join('streams', 'streams.id', '=', 'class.stream_id')
            ->join('users as teachers_user', 'teachers_user.id', '=', 'teachers.user_id')
            ->join('users as student_user', 'student_user.id', '=', 'students.user_id')
            ->select(
                'student_user.first_name as student_first_name',
                'student_user.last_name as student_last_name',
                'class.label as class_label',
                'streams.stream as stream',
                'teachers_user.name as teacher_name',
                'students.class_id',
                'students.teacher_id',
                'students.parent_id'
            )
            ->where('students.admission_number', $admissionNo)
            ->whereNull('students.parent_id')
            ->first();
        Log::info("mesage  ".json_encode($student));

        if ($student) {
            return response()->json([
                'success' => true,
                'name'    => $student->student_first_name . ' ' . $student->student_last_name,
                'class'   => $student->class_label . ' ' . $student->stream,
                'teacher' => $student->teacher_name,
                'class_id'    => $student->class_id,
                'teacher_id'  => $student->teacher_id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.',
            ]);
        }

    }

    public function findStudents (Request $request, $id)
    {
        Log::info("the id " .$id);
        $students = DB::table('students')
            ->join('parents', 'parents.id','students.parent_id')
            ->join('users', 'users.id', 'students.user_id')
            ->join('class','class.id','students.class_id')
            ->join('streams', 'streams.id','class.stream_id')
            ->join('teachers', 'teachers.id', 'students.teacher_id')
            ->join('users as u', 'u.id', 'teachers.user_id')
            ->select('users.name as student_name',
                    'class.label as class_label',
                    'class.stream_id',
                    'u.name as teacher_name'
                    )
            ->where('students.parent_id', $id)
            ->get();

        Log::info("the students " . json_encode($students));

        if($students->isEmpty())
        {
            return response()->json([
                'success' => false,
                'message' => 'No students found for this parent.',
                'students' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }


}
