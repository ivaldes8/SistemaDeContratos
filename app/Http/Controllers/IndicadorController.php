<?php

namespace App\Http\Controllers;

use App\Models\indicador;
use Illuminate\Http\Request;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indicador = indicador::paginate(10);
        return view('indicador.index',compact('indicador'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $indicador = 'none';
        return view('indicador.edit', compact('indicador'));
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

        $indicador = new indicador();
        $indicador->codigo = $request->input('codigo');
        $indicador->desc = $request->input('desc');
        $indicador->save($validatedData);
        return redirect('/indicador')->with('status','Indicador creado satisfactoriamente');
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
        $indicador = indicador::find($id);
        return view('indicador.edit', compact('indicador'));
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

        $indicador = indicador::find($id);
        $indicador->codigo = $request->input('codigo');
        $indicador->desc = $request->input('indicador');
        $indicador->update($validatedData);
        return redirect('/indicador')->with('status','Indicador editado satisfactoriamente');
    }

    public function delete($id)
    {
        $indicador = indicador::find($id);
        return view('indicador.delete', compact('indicador'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indicador = indicador::find($id);
        $indicador->delete();
        return redirect()->back()->with('status','Indicador eliminado Satisfactoriamente');
    }
}
