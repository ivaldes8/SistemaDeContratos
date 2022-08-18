<?php

namespace App\Http\Controllers;

use App\Models\Organismo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganismoExport;

class OrganismoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Organismo::query();

        $query->when(request()->input('codigo'), function($q) {
            return $q->where('codigo', 'like', '%'.request()->input('codigo').'%');
        });

        $query->when(request()->input('nombre'), function($q) {
            return $q->where('nombre', 'like', '%'.request()->input('nombre').'%');
        });

        $query->when(request()->input('siglas'), function($q) {
            return $q->where('siglas', 'like', '%'.request()->input('siglas').'%');
        });

        $organismo = $query->paginate(10);

        return view('organismo.index',compact('organismo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organismo = 'none';
        return view('organismo.edit', compact('organismo'));
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
            'codigo' => 'required',
            'siglas' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $organismo = new Organismo();
        $organismo->nombre = $request->input('nombre');
        $organismo->siglas = $request->input('siglas');
        $organismo->codigo = $request->input('codigo');
        $organismo->activo = $request->input('activo') ? 1 : 0;
        $organismo->save($validatedData);
        return redirect('/organismo')->with('status','Organismo creado satisfactoriamente');
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
        $organismo = organismo::find($id);
        return view('organismo.edit', compact('organismo'));
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
            'codigo' => 'required',
            'siglas' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $organismo = Organismo::find($id);
        $organismo->nombre = $request->input('nombre');
        $organismo->siglas = $request->input('siglas');
        $organismo->codigo = $request->input('codigo');
        $organismo->activo = $request->input('activo') ? 1 : 0;
        $organismo->update($validatedData);
        return redirect('/organismo')->with('status','Orgnismo Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $organismo = Organismo::find($id);
        return view('organismo.delete', compact('organismo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organismo = Organismo::find($id);
        $organismo->delete();
        return redirect()->back()->with('status','Organismo eliminado Satisfactoriamente');
    }

    public function export()
    {
        return Excel::download(new OrganismoExport, 'organismos.xlsx');
    }
}
