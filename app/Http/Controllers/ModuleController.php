<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Container\Attributes\DB;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Validator;

use function Illuminate\Log\log;

class ModuleController extends Controller
{
    //
    public function index (){
        $modules = FacadesDB::table('modules')->get();
        return view('assignments.modules', compact('modules'));
    }

    public function store (Request $request) {

        FacadesLog::info("gets here");

        //validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'slug'   => 'required|string|max:255|unique:modules,slug',
            'icon'   => 'nullable|string|max:255',
            'url'    => 'nullable|url|max:255',
            'order'  => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $module = Module::create($data);

        return response()->json([
            'message' => 'Module saved successfully.',
            'module'  => $module
        ]);
    }
}
