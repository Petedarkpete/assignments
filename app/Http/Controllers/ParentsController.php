<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\ParentProfile;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ParentsController extends Controller
{
    //
    public function parentsView()
    {
        $parents = DB::table('parents')
            ->join('users', 'parents.user_id', 'users.id')
            ->leftJoin('students', 'parents.id', '=', 'students.parent_id')
            ->select(
                'parents.id as parent_id',
                'parents.*',
                'users.*',
                DB::raw('COUNT(students.id) as student_count'),
            )
            ->groupBy('parents.id', 'users.id')
            ->get();
        $classes = Clas::all();
        return view('users.parents.view', compact('parents', 'classes'));
    }
    public function createParent () {

        return view ('users.parents.create');
    }

    public function secondStudent () {

        return view ('users.parents.second_student');
    }

    public function storeParent(Request $request)
    {
        Log::info("all the info" . json_encode($request->all()));

        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'other_names'    => 'nullable|string|max:255',
            'email'          => 'nullable|email|unique:users,email',
            'phone'          => 'nullable|string|max:20',
            'gender'         => 'required|in:Male,Female',
            'address'        => 'nullable|string|max:255',
            'relationship'   => 'required|string|max:100',
            'occupation'     => 'required|string|max:100',
            'admission_no'   => 'required|string|exists:students,admission_number',
            'class_id'       => 'required|exists:class,id',
            'teacher_id'     => 'required|exists:teachers,id',
            'add_student'    => 'required'
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'name'       => $validated['first_name'] . ' ' . $validated['last_name'],
                'email'      => $validated['email'] ?? null,
                'gender'     => $validated['gender'],
                'password'   => Hash::make(Str::random(12)),
            ]);

            // Find student
            $student = Student::where('admission_number', $validated['admission_no'])->firstOrFail();

            // Create parent/guardian
            $parent = ParentProfile::create([
                'user_id'      => $user->id,
                'student_id'   => $student->id,
                'other_names'  => $validated['other_names'] ?? null,
                'phone'        => $validated['phone'] ?? null,
                'address'      => $validated['address'] ?? null,
                'relationship' => $validated['relationship'],
                'occupation'   => $validated['occupation'],
            ]);

            //add parent to student
            $updateSuccess = $student->update([
                'parent_id' => $parent->id,
            ]);

            // if ($updateSuccess) {
            //     Log::info("Student [ID: {$student->id}] updated with parent ID {$parent->id} successfully.");
            // } else {
            //     Log::warning("Failed to update Student [ID: {$student->id}] with parent ID {$parent->id}.");
            // }

            DB::commit();

            if($validated['add_student'] = 'yes'){
            return redirect()->to('/parents/second_student')
                ->with('success', 'Parent created successfully. Add information for second student')
                //pass the parent_id of the new saved parent as a session
                ->with('parent_id', $parent->id);
            } else {
                return redirect()->to('/parents/view')
                ->with('success', 'Teacher created successfully.');
            }


        }  catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Validation error: Please fill all required fields correctly.',
            ], 422);
        }

        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Teacher creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while creating teacher.',
            ], 500);
        }
    }

    public function secondStudentStore (Request $request)
    {
        $validated = $request->validate([
            'admission_no'   => 'required|string|exists:students,admission_number',
            'class_id'       => 'required|exists:class,id',
            'teacher_id'     => 'required|exists:teachers,id',
            'add_student'    => 'required'
        ]);
        DB::beginTransaction();
        try {
            Log::info("all the info" . json_encode($request->all()));
            $student = Student::where('admission_number', $validated['admission_no'])->firstOrFail();

            $updateSuccess = $student->update([
                'parent_id' => $request->parent_id,
            ]);
             if (!$updateSuccess) {
                throw new \Exception('Failed to update student.');
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Student updated successfully.']);
        } catch (\Throwable $th) {

            DB::rollBack();
            Log::error('Error in adding second student ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    public function destroyParent($id)
    {
        try {
            Log::info("Gets here.--");
            $subject = ParentProfile::findOrFail($id);
            $subject->delete();

            return response()->json(['success' => true, 'message' => 'Parent deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
