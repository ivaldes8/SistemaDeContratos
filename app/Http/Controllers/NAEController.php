<?php

namespace App\Http\Controllers;

use App\Models\nae;
use Illuminate\Http\Request;
use App\Imports\CNAEImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CNAEExport;

class NAEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = nae::query();

        $query->when(request()->input('codigo'), function($q) {
            return $q->where('codigo', 'like', '%'.request()->input('codigo').'%');
        });

        $query->when(request()->input('desc'), function($q) {
            return $q->where('desc', 'like', '%'.request()->input('desc').'%');
        });

        $cnae = $query->paginate(50);
        return view('cnae.index',compact('cnae'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cnae = 'none';
        return view('cnae.edit', compact('cnae'));
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

        $cnae = new nae();
        $cnae->desc = $request->input('desc');
        $cnae->codigo = $request->input('codigo');
        $cnae->save($validatedData);
        return redirect('/cnae')->with('status','CNAE creado satisfactoriamente');
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
        $cnae = nae::find($id);
        return view('cnae.edit', compact('cnae'));
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

        $cnae = nae::find($id);
        $cnae->desc = $request->input('desc');
        $cnae->codigo = $request->input('codigo');
        $cnae->update($validatedData);
        return redirect('/cnae')->with('status','CNAE Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $cnae = nae::find($id);
        return view('cnae.delete', compact('cnae'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cnae = nae::find($id);
        $cnae->delete();
        return redirect()->back()->with('status','CNAE eliminado Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('cnae.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new CNAEImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new CNAEExport, 'cnae.xlsx');
    }
}
