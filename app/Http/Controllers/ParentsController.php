<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\ParentProfile;
use App\Models\Stream;
use App\Models\Subject;
use Illuminate\Http\Request;

class ParentsController extends Controller
{
    //
    public function parentsView()
    {
        $parents = ParentProfile::all();
        $classes = Clas::all();
        return view('users.parents.view', compact('parents', 'classes'));
    }
    public function createParent () {

        return view ('users.parents.create');
    }

    public function storeParent () {
        
    }
}
