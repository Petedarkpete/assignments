<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Submodule;
use Illuminate\Container\Attributes\DB;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;

use function Illuminate\Log\log;

class ModuleController extends Controller
{
    //
    public function index (){
        $modules = FacadesDB::table('modules')->get();
        $submodules = FacadesDB::table('submodules')->get();
        return view('assignments.modules', compact('modules','submodules'));
    }

    public function store (Request $request) {

        FacadesLog::info("gets here");

        //validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $slug = strtolower(str_replace('','_', $validator['name']));

        $validator['slug'] = $slug;
        $validator['url'] = $slug . '/view';

        $data = $validator->validated();


        $module = Module::create($data);

        return response()->json([
            'message' => 'Module saved successfully.',
            'module'  => $module
        ]);
    }

    public function storeSubModule(Request $request) {
        FacadesLog::info("gets here");

        //validation
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'slug'       => 'required|string|max:255|unique:submodules,slug',
            'module_id'  => 'required|exists:modules,id', // ensure it links to a valid module
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        FacadesLog::info("the data -- " . json_encode($data));
        dd($data);

        $module = Submodule::create($data);

        return response()->json([
            'message' => 'Module saved successfully.',
            'module'  => $module
        ]);

    }
}
