<?php

namespace App\Http\Controllers;

use App\Models\saclap;
use Illuminate\Http\Request;
use App\Imports\SACLAPImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SACLAPExport;

class SACLAPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = saclap::query();

        $query->when(request()->input('codigo'), function($q) {
            return $q->where('codigo', 'like', '%'.request()->input('codigo').'%');
        });

        $query->when(request()->input('desc'), function($q) {
            return $q->where('desc', 'like', '%'.request()->input('desc').'%');
        });

        $saclap = $query->paginate(50);
        return view('saclap.index',compact('saclap'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $saclap = 'none';
        return view('saclap.edit', compact('saclap'));
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
            'codigo' => 'required'
        ], [
            'desc.required' => 'Este campo es requerido',
            'codigo.required' => 'Este campo es requerido'
        ]);

        $saclap = new saclap();
        $saclap->desc = $request->input('desc');
        $saclap->codigo = $request->input('codigo');
        $saclap->save($validatedData);
        return redirect('/saclap')->with('status','SACLAP creado satisfactoriamente');
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
        $saclap = saclap::find($id);
        return view('saclap.edit', compact('saclap'));
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
            'desc' => 'required',
            'codigo' => 'required'
        ], [
            'desc.required' => 'Este campo es requerido',
            'codigo.required' => 'Este campo es requerido'
        ]);

        $saclap = saclap::find($id);
        $saclap->desc = $request->input('desc');
        $saclap->codigo = $request->input('codigo');
        $saclap->update($validatedData);
        return redirect('/saclap')->with('status','SACLAP Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $saclap = saclap::find($id);
        return view('saclap.delete', compact('saclap'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $saclap = saclap::find($id);
        $saclap->delete();
        return redirect()->back()->with('status','SACLAP eliminado Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('saclap.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new SACLAPImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new SACLAPExport, 'saclap.xlsx');
    }
}
