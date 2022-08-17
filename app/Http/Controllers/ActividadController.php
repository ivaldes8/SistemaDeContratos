<?php

namespace App\Http\Controllers;

use App\Models\actividad;
use Illuminate\Http\Request;
use App\Imports\ActividadIndustrialImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActividadIndustrialExport;


class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = actividad::query();

        $query->when(request()->input('codigo'), function($q) {
            return $q->where('codigo', 'like', '%'.request()->input('codigo').'%');
        });

        $query->when(request()->input('desc'), function($q) {
            return $q->where('desc', 'like', '%'.request()->input('desc').'%');
        });
        $actividad = $query->paginate(50);
        return view('actividad.index',compact('actividad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actividad = 'none';
        return view('actividad.edit', compact('actividad'));
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
            'codigo' => 'required',
            'desc' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $actividad = new actividad();
        $actividad->codigo = $request->input('codigo');
        $actividad->desc = $request->input('desc');
        $actividad->save($validatedData);
        return redirect('/actividad')->with('status','Actividad Industrial creada satisfactoriamente');
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
        $actividad = actividad::find($id);
        return view('actividad.edit', compact('actividad'));
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
            'codigo' => 'required',
            'desc' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $actividad = actividad::find($id);
        $actividad->codigo = $request->input('codigo');
        $actividad->desc = $request->input('actividad');
        $actividad->update($validatedData);
        return redirect('/actividad')->with('status','Actividad Industrial Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $actividad = actividad::find($id);
        return view('actividad.delete', compact('actividad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = actividad::find($id);
        $actividad->delete();
        return redirect()->back()->with('status','Actividad Industrial eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('actividad.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new ActividadIndustrialImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new ActividadIndustrialExport, 'actividades_industriales.xlsx');
    }
}
