<?php

namespace App\Http\Controllers;

use App\Models\objSupCP;
use Illuminate\Http\Request;

class ObjSupCPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = objSupCP::query();

        $query->when(request()->input('nombre'), function ($q) {
            return $q->where('nombre', 'like', '%' . request()->input('nombre') . '%');
        });

        $query->when(request()->input('activo'), function ($q) {
            return $q->where('activo', 1);
        });

        $objeto = $query->paginate(10);

        return view('objSupCP.index', compact('objeto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objeto = 'none';
        return view('objSupCP.edit', compact('objeto'));
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

        $objeto = new objSupCP();
        $objeto->nombre = $request->input('nombre');
        $objeto->activo = $request->input('activo') ? 1 : 0;
        $objeto->save($validatedData);
        return redirect('/objsupcp')->with('status', 'Objeto de suplemento creado satisfactoriamente');
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
        $objeto = objSupCP::find($id);
        return view('objSupCP.edit', compact('objeto'));
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

        $objeto = objSupCP::find($id);
        $objeto->nombre = $request->input('nombre');
        $objeto->activo = $request->input('activo') ? 1 : 0;
        $objeto->update($validatedData);
        return redirect('/objsupcp')->with('status', 'Objeto de suplemento Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $objeto = objSupCP::find($id);
        return view('objSupCP.delete', compact('objeto'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objeto = objSupCP::find($id);
        $objeto->delete();
        return redirect()->back()->with('status', 'Objeto de suplemento eliminado Satisfactoriamente');
    }
}
