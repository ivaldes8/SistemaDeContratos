<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganismoExport;
use App\Models\estadoCP;

class EstadoCPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = estadoCP::query();

        $query->when(request()->input('nombre'), function($q) {
            return $q->where('nombre', 'like', '%'.request()->input('nombre').'%');
        });

        $query->when(request()->input('activo'), function($q) {
            return $q->where('activo', 1);
        });

        $estado = $query->paginate(10);

        return view('estadoCP.index',compact('estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = 'none';
        return view('estadoCP.edit', compact('estado'));
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

        $estado = new estadoCP();
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->save($validatedData);
        return redirect('/estadocp')->with('status','Estado creado satisfactoriamente');
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
        $estado = estadoCP::find($id);
        return view('estadoCP.edit', compact('estado'));
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

        $estado = estadoCP::find($id);
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->update($validatedData);
        return redirect('/estadocp')->with('status','Estado editado satisfactoriamente');
    }

    public function delete($id)
    {
        $estado = estadoCP::find($id);
        return view('estadoCP.delete', compact('estado'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estado = estadoCP::find($id);
        $estado->delete();
        return redirect()->back()->with('status','Estado eliminado Satisfactoriamente');
    }

    public function export()
    {
        return Excel::download(new OrganismoExport, 'organismos.xlsx');
    }
}
