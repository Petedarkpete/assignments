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
        $validated = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors()
            ], 422);
        }
        $data = $validated->validated();

        $slug = strtolower(str_replace('','_', $data['name']));

        $data['slug'] = $slug;
        $data['url'] = $slug . '/view';

        $module = Module::create($data);

        return response()->json([
            'message' => 'Module saved successfully.',
            'module'  => $module
        ]);
    }

    public function storeSubModule(Request $request) {
        FacadesLog::info("gets here");

        //validation
        $validated = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'module_id'  => 'required|exists:modules,id', // ensure it links to a valid module
        ]);

        if ($validated->fails()) {
            return response()->json([
                'errors' => $validated->errors()
            ], 422);
        }

        $data = $validated->validated();

        $slug = strtolower(str_replace('','_', $data['name']));

        if(empty($data['url'])){
            $data['slug'] = $slug;
            $data['url'] = $slug . '/view';
        }

        $module = Submodule::create($data);

        return response()->json([
            'message' => 'Module saved successfully.',
            'module'  => $module
        ]);

    }
}
