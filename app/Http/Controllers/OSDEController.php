<?php

namespace App\Http\Controllers;

use App\Models\osde;
use Illuminate\Http\Request;
use App\Imports\OSDEImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OSDEExport;

class OSDEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $osde = osde::paginate(10);
        return view('osde.index',compact('osde'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $osde = 'none';
        return view('osde.edit', compact('osde'));
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

        $osde = new osde();
        $osde->name = $request->input('name');
        $osde->siglas = $request->input('siglas');
        $osde->codigo = $request->input('codigo');
        $osde->save($validatedData);
        return redirect('/osde')->with('status','OSDE creada satisfactoriamente');
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
        $osde = osde::find($id);
        return view('osde.edit', compact('osde'));
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
            'codigo' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'codigo.required' => 'Este campo es requerido'
        ]);

        $osde = osde::find($id);
        $osde->name = $request->input('name');
        $osde->siglas = $request->input('siglas');
        $osde->codigo = $request->input('codigo');
        $osde->update($validatedData);
        return redirect('/osde')->with('status','OSDE Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $osde = osde::find($id);
        return view('osde.delete', compact('osde'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $osde = osde::find($id);
        $osde->delete();
        return redirect()->back()->with('status','OSDE eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('osde.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new OSDEImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new OSDEExport, 'osdes.xlsx');
    }
}
