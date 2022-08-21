<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganismoExport;
use App\Models\estadoCM;

class EstadoCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = estadoCM::query();

        $query->when(request()->input('nombre'), function($q) {
            return $q->where('nombre', 'like', '%'.request()->input('nombre').'%');
        });

        $query->when(request()->input('activo'), function($q) {
            return $q->where('activo', 1);
        });

        $estado = $query->paginate(10);

        return view('estadoCM.index',compact('estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = 'none';
        return view('estadoCM.edit', compact('estado'));
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

        $estado = new estadoCM();
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->save($validatedData);
        return redirect('/estadocm')->with('status','Estado creado satisfactoriamente');
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
        $estado = estadoCM::find($id);
        return view('estadoCM.edit', compact('estado'));
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

        $estado = estadoCM::find($id);
        $estado->nombre = $request->input('nombre');
        $estado->activo = $request->input('activo') ? 1 : 0;
        $estado->update($validatedData);
        return redirect('/estadocm')->with('status','Estado editado satisfactoriamente');
    }

    public function delete($id)
    {
        $estado = estadoCM::find($id);
        return view('estadoCM.delete', compact('estado'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estado = estadoCM::find($id);
        $estado->delete();
        return redirect()->back()->with('status','Estado eliminado Satisfactoriamente');
    }

    public function export()
    {
        return Excel::download(new OrganismoExport, 'organismos.xlsx');
    }
}
