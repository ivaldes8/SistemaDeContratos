<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrganismoExport;
use App\Models\tipoCP;

class TipoCPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = tipoCP::query();

        $query->when(request()->input('nombre'), function($q) {
            return $q->where('nombre', 'like', '%'.request()->input('nombre').'%');
        });

        $query->when(request()->input('activo'), function($q) {
            return $q->where('activo', 1);
        });

        $tipo = $query->paginate(10);

        return view('tipoCP.index',compact('tipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo = 'none';
        return view('tipoCP.edit', compact('tipo'));
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

        $tipo = new tipoCP();
        $tipo->nombre = $request->input('nombre');
        $tipo->activo = $request->input('activo') ? 1 : 0;
        $tipo->save($validatedData);
        return redirect('/tipocp')->with('status','Tipo creado satisfactoriamente');
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
        $tipo = tipoCP::find($id);
        return view('tipoCP.edit', compact('tipo'));
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

        $tipo = tipoCP::find($id);
        $tipo->nombre = $request->input('nombre');
        $tipo->activo = $request->input('activo') ? 1 : 0;
        $tipo->update($validatedData);
        return redirect('/tipocp')->with('status','Tipo Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $tipo = tipoCP::find($id);
        return view('tipoCP.delete', compact('tipo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo = tipoCP::find($id);
        $tipo->delete();
        return redirect()->back()->with('status','Tipo eliminado Satisfactoriamente');
    }

    public function export()
    {
        return Excel::download(new OrganismoExport, 'organismos.xlsx');
    }
}
