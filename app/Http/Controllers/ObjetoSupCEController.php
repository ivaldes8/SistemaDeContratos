<?php

namespace App\Http\Controllers;

use App\Models\ObjetoSuplementoCE;
use Illuminate\Http\Request;

class ObjetoSupCEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = ObjetoSuplementoCE::paginate(50);
        $links = true;
        return view('objSupCE.index', compact('obj','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objSupCE.create');
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
            'objeto' => 'required',
        ],[
            'objeto.required' => 'Tiene que introducir un objeto'
        ]);
        $obj = new ObjetoSuplementoCE();
        $obj->ObjetoSuplementoCE = $request->input('objeto');
        $obj->save($validatedData);
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
        $obj = ObjetoSuplementoCE::find($id);
        
        return view('objSupCE.edit', compact('obj'));
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
            'objeto' => 'required',
        ],[
            'objeto.required' => 'Tiene que introducir un objeto'
        ]);

        $obj = ObjetoSuplementoCE::find($id);
        $obj->ObjetoSuplementoCE = $request->input('objeto');
        $obj->update($validatedData);
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
        $obj = ObjetoSuplementoCE::find($id);
        $obj->delete();
        return redirect()->back()->with('status', 'Objeto eliminado satisfactoriamente');
    }
}
