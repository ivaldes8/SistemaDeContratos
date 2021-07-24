<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Organismo;
use Illuminate\Http\Request;
use App\Rules\noOrganismo;

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
        $organismo = Organismo::all();
        return view('grupo.index',compact('grupo','organismo'));
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
        $validatedData = $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_Organismo' => ['required', new noOrganismo()]
        ],[
            'codigo.required' => 'Tiene que introducir un código',
            'nombre.required' => 'Tiene que introducir un nombre',
            'id_Organismo.required' => 'Tiene que seleccionar un organismo'
        ]);

        $grupo = new Grupo();
        $grupo->codigoG = $request->input('codigo');
        $grupo->nombreG = $request->input('nombre');
        $grupo->siglasG = $request->input('siglas');
        $grupo->id_Organismo = $request->input('id_Organismo');
        $grupo->activoG = $request->input('activo') == true ? '1' : '0';
        //dd($request);
        $grupo->save($validatedData);
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
        $validatedData = $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_Organismo' => ['required', new noOrganismo()]
        ],[
            'codigo.required' => 'Tiene que introducir un código',
            'nombre.required' => 'Tiene que introducir un nombre',
            'id_Organismo.required' => 'Tiene que seleccionar un organismo'
        ]);

        $grupo = Grupo::find($id);

        $grupo->codigoG = $request->input('codigo');
        $grupo->nombreG = $request->input('nombre');
        $grupo->siglasG = $request->input('siglas');
        $grupo->activoG = $request->input('activo') == true ? '1' : '0';
        $grupo->id_Organismo = $request->input('id_Organismo');

        $grupo->update($validatedData);
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
