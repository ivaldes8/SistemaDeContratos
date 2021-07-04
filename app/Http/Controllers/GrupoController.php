<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Organismo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupo = Grupo::all();
        return view('grupo.index',compact('grupo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organismo = Organismo::all();
        return view('grupo.create',compact('organismo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grupo = new Grupo();
        $grupo->codigo = $request->input('codigo');
        $grupo->nombre = $request->input('nombre');
        $grupo->siglas = $request->input('siglas');
        $grupo->id_Organismo = $request->input('id_Organismo');
        $grupo->activo = $request->input('activo') == true ? '1' : '0';
        //dd($grupo);
        $grupo->save();
        return redirect()->back()->with('status', 'Grupo añadido satisfactoriamente');
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
        $organismo = Organismo::all();
        $grupo = Grupo::find($id);
        return view('grupo.edit', compact('grupo','organismo'));
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
        $grupo = Grupo::find($id);

        $grupo->codigo = $request->input('codigo');
        $grupo->nombre = $request->input('nombre');
        $grupo->siglas = $request->input('siglas');
        $grupo->activo = $request->input('activo') == true ? '1' : '0';
        $grupo->id_Organismo = $request->input('id_Organismo');

        $grupo->update();
        return redirect()->back()->with('status', 'Grupo editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = Grupo::find($id);
        $grupo->delete();
        return redirect()->back()->with('status', 'Grupo Eliminado satisfactoriamente');
    }
}
