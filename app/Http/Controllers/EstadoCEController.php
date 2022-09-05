<?php

namespace App\Http\Controllers;

use App\Models\estadoCE;
use Illuminate\Http\Request;

class EstadoCEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = estadoCE::query();

        $query->when(request()->input('nombre'), function ($q) {
            return $q->where('nombre', 'like', '%' . request()->input('nombre') . '%');
        });

        $query->when(request()->input('activo'), function ($q) {
            return $q->where('activo', 1);
        });

        $estado = $query->paginate(10);

        return view('estadoCE.index', compact('estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = 'none';
        return view('estadoCE.edit', compact('estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $estado = new estadoCE();
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->save($validatedData);
        return redirect('/estadoce')->with('status','Estado creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = estadoCE::find($id);
        return view('estadoCE.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $estado = estadoCE::find($id);
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->update($validatedData);
        return redirect('/estadoce')->with('status','Estado editado satisfactoriamente');
    }

    public function delete($id)
    {
        $estado = estadoCE::find($id);
        return view('estadoCE.delete', compact('estado'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estado = estadoCE::find($id);
        $estado->delete();
        return redirect()->back()->with('status','Estado eliminado Satisfactoriamente');
    }
}
