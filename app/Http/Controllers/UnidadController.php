<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UnidadImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UnidadExport;
use App\Models\unidad;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $unidad = unidad::paginate(50);
        return view('unidad.index',compact('unidad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidad = 'none';
        return view('unidad.edit', compact('unidad'));
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
            'desc' => 'required',
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $unidad = new unidad();
        $unidad->desc = $request->input('desc');
        $unidad->save($validatedData);
        return redirect('/unidad')->with('status','Unidad creada satisfactoriamente');
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
        $unidad = unidad::find($id);
        return view('unidad.edit', compact('unidad'));
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
            'desc' => 'required'
        ], [
            'desc.required' => 'Este campo es requerido'
        ]);

        $unidad = unidad::find($id);
        $unidad->desc = $request->input('desc');
        $unidad->update($validatedData);
        return redirect('/unidad')->with('status','Unidad Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $unidad = unidad::find($id);
        return view('unidad.delete', compact('unidad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unidad = unidad::find($id);
        $unidad->delete();
        return redirect()->back()->with('status','Unidad eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('unidad.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new UnidadImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new UnidadExport, 'unidad.xlsx');
    }
}
