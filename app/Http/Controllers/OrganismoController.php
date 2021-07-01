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
        $organismo = Organismo::all();
        return view('organismo.index',compact('organismo'));
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
        $organismo = new Organismo();
        $organismo->codigo = $request->input('codigo');
        $organismo->nombre = $request->input('nombre');
        $organismo->siglas = $request->input('siglas');
        $organismo->nombre = $request->input('nombre');
        $organismo->activo = $request->input('activo') == true ? '1' : '0';
        $organismo->save();
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
        $organismo = Organismo::find($id);

        $organismo->codigo = $request->input('codigo');
        $organismo->nombre = $request->input('nombre');
        $organismo->siglas = $request->input('siglas');
        $organismo->nombre = $request->input('nombre');
        $organismo->activo = $request->input('activo') == true ? '1' : '0';

        $organismo->update();
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
