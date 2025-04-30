<?php

namespace App\Http\Controllers;

use App\Models\Subject;
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:subjects,code',
                'status' => 'required|in:Active,Inactive',
            ]);

            Subject::create($validated);

            return redirect()->route('subject.view')->with('success', 'Subject added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
