<?php

namespace App\Http\Controllers;

use App\Models\Organismo;
use Illuminate\Http\Request;

class OrganismoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organismo = Organismo::paginate(50);
        $links = true;
        return view('organismo.index',compact('organismo','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('organismo.create');
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
            'siglas' => 'required'
        ],[
            'codigo.required' => 'Tiene que introducir un código',
            'nombre.required' => 'Tiene que introducir un nombre',
            'siglas.required' => 'Tiene que introducir las siglas'
        ]);

        $organismo = new Organismo();
        $organismo->codigoO = $request->input('codigo');
        $organismo->nombreO = $request->input('nombre');
        $organismo->siglasO = $request->input('siglas');
        $organismo->activoO = $request->input('activo') == true ? '1' : '0';
        $organismo->save($validatedData);
        return redirect()->back()->with('status', 'Organismo añadido satisfactoriamente');
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
        $organismo = Organismo::find($id);
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
            'codigo' => 'required',
            'nombre' => 'required',
            'siglas' => 'required'
        ],[
            'codigo.required' => 'Tiene que introducir un código',
            'nombre.required' => 'Tiene que introducir un nombre',
            'siglas.required' => 'Tiene que introducir las siglas'
        ]);

        $organismo = Organismo::find($id);

        $organismo->codigoO = $request->input('codigo');
        $organismo->nombreO = $request->input('nombre');
        $organismo->siglasO = $request->input('siglas');
        $organismo->activoO = $request->input('activo') == true ? '1' : '0';

        $organismo->update($validatedData);
        return redirect()->back()->with('status', 'Organismo editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organismo = Organismo::find($id);
        $organismo->delete();
        return redirect()->back()->with('status', 'Organismo Eliminado satisfactoriamente');
    }
}
