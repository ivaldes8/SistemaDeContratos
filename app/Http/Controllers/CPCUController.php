<?php

namespace App\Http\Controllers;

use App\Models\cpcu;
use Illuminate\Http\Request;
use App\Imports\CPCUImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CPCUExport;

class CPCUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = cpcu::query();

        $query->when(request()->input('codigo'), function($q) {
            return $q->where('codigo', 'like', '%'.request()->input('codigo').'%');
        });

        $query->when(request()->input('desc'), function($q) {
            return $q->where('desc', 'like', '%'.request()->input('desc').'%');
        });

        $cpcu = $query->paginate(50);
        return view('cpcu.index',compact('cpcu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cpcu = 'none';
        return view('cpcu.edit', compact('cpcu'));
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

        $cpcu = new cpcu();
        $cpcu->desc = $request->input('desc');
        $cpcu->codigo = $request->input('codigo');
        $cpcu->save($validatedData);
        return redirect('/cpcu')->with('status','CPCU creado satisfactoriamente');
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
        $cpcu = cpcu::find($id);
        return view('cpcu.edit', compact('cpcu'));
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

        $cpcu = cpcu::find($id);
        $cpcu->desc = $request->input('desc');
        $cpcu->codigo = $request->input('codigo');
        $cpcu->update($validatedData);
        return redirect('/cpcu')->with('status','CPCU Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $cpcu = cpcu::find($id);
        return view('cpcu.delete', compact('cpcu'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cpcu = cpcu::find($id);
        $cpcu->delete();
        return redirect()->back()->with('status','CPCU eliminado Satisfactoriamente');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImportExport()
    {
        return view('cpcu.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new CPCUImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new CPCUExport, 'cpcu.xlsx');
    }
}
