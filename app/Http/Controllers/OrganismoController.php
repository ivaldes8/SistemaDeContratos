<?php

namespace App\Http\Controllers;

use App\Models\organismo;
use Illuminate\Http\Request;
use App\Imports\OrganismoImport;
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
        $organismo = organismo::paginate(10);
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
            'name' => 'required',
            'codigo' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'codigo.required' => 'Este campo es requerido'
        ]);

        $organismo = new organismo();
        $organismo->name = $request->input('name');
        $organismo->siglas = $request->input('siglas');
        $organismo->codigo = $request->input('codigo');
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
            'name' => 'required',
            'codigo' => 'required',
        ], [
            'name.required' => 'Este campo es requerido',
            'codigo.required' => 'Este campo es requerido',
        ]);

        $organismo = organismo::find($id);
        $organismo->name = $request->input('name');
        $organismo->siglas = $request->input('siglas');
        $organismo->codigo = $request->input('codigo');
        $organismo->update($validatedData);
        return redirect('/organismo')->with('status','Orgnismo Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $organismo = organismo::find($id);
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
        $organismo = organismo::find($id);
        $organismo->delete();
        return redirect()->back()->with('status','Organismo eliminado Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('organismo.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new OrganismoImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new OrganismoExport, 'organismos.xlsx');
    }
}
