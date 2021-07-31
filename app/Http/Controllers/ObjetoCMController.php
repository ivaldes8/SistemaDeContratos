<?php

namespace App\Http\Controllers;

use App\Models\ObjetoCM;
use Illuminate\Http\Request;

class ObjetoCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objeto =ObjetoCM::paginate(50);
        $links = true;
        return view('objeto_CM.index',compact('objeto','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objeto_CM.create');
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
            'nombre' => 'required',
        ],[
            'nombre.required' => 'Tiene que introducir un nombre',
        ]);

        $objeto = new ObjetoCM();
        $objeto->nombre = $request->input('nombre');
        $objeto->save($validatedData);
        return redirect()->back()->with('status', 'Objeto añadido satisfactoriamente');
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
        $objeto = ObjetoCM::find($id);
        return view('objeto_CM.edit', compact('objeto'));
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
            'nombre' => 'required',
        ],[
            'nombre.required' => 'Tiene que introducir un nombre',
        ]);

        $objeto = ObjetoCM::find($id);

        $objeto->nombre = $request->input('nombre');

        $objeto->update($validatedData);
        return redirect()->back()->with('status', 'Objeto editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objeto = ObjetoCM::find($id);
        $objeto->delete();
        return redirect()->back()->with('status', 'Objeto Eliminado satisfactoriamente');
    }
}
