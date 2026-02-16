<?php

namespace App\Http\Controllers;

use App\Models\Engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EngineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // public function getEngines()
    // {
    //     $engines = DB::select('EXEC sp_GetAllEngines', []);
    //     $headers =
    // }

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
        $validatedData = $request->validate([
            'displacement' => 'required|integer',
            'cylinder_count' => 'required|integer',
        ]);

        $engine = Engine::factory()->make();

        $newCode = $engine->code; // Generate a unique code using the factory

        DB::insert('EXEC sp_CreateEngine @Code = ?, @Displacement = ?, @Cylinder_Count = ?', [
            $newCode,
            $validatedData['displacement'],
            $validatedData['cylinder_count']
        ]);

        return redirect('/')->with('success', 'Engine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $engines = DB::select('EXEC sp_GetAllEngines', []);
        $headers = ['ID', 'Code', 'Displacement', 'Cylinder Count', 'Created At', 'Updated At'];
        return view('home', ['headers' => $headers, 'rows' => $engines]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Engine $engine)
    // {
    //     //
    // }

    public function edit($code)
    {
        $engine = DB::select('EXEC sp_GetEngineByCode @Code = ?', [$code]);

        // because select returns array
        $engine = $engine[0] ?? null;

        if (!$engine) {
            return redirect('/')->with('error', 'Engine not found.');
        }

        return view('update_engine_form', compact('engine'));
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Engine $engine)
    // {
    //     //
    // }

    public function update(Request $request, $code)
    {
        $validatedData = $request->validate([
            'displacement' => 'required|integer',
            'cylinder_count' => 'required|integer',
        ]);

        DB::update(
            'EXEC sp_UpdateEngine @Code = ?, @Displacement = ?, @Cylinder_Count = ?',
            [
                $code,
                $validatedData['displacement'],
                $validatedData['cylinder_count']
            ]
        );

        return redirect('/')->with('success', 'Engine updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Engine $engine)
    {
        //


    }
}
