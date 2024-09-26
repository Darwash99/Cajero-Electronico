<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tareas::all();
        return Inertia::render('Tareas/index',compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'autor' => 'required',
            'album' => 'required',
        ]);
        $tareas = new Tareas($request->input());
        $tareas->save();

        return redirect('tareas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tareas $tareas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tareas $tareas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $tareas = Tareas::find($id);
        $tareas->fill($request->input())->saveOrFail();
        return redirect('tareas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tareas = Tareas::find($id);
        $tareas->delete();
        return redirect()->route('tareas.index');
    }
}
