<?php

namespace App\Http\Controllers;

use App\Models\ObjetoSuplementoCM;
use Illuminate\Http\Request;

class ObjetoSupCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = ObjetoSuplementoCM::paginate(50);
        $links = true;
        return view('objSupCM.index', compact('obj','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objSupCM.create');
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
        $obj = new ObjetoSuplementoCM();
        $obj->ObjetoSuplementoCM = $request->input('objeto');
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
        $obj = ObjetoSuplementoCM::find($id);
        
        return view('objSupCM.edit', compact('obj'));
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

        $obj = ObjetoSuplementoCM::find($id);
        $obj->ObjetoSuplementoCM = $request->input('objeto');
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
        $obj = ObjetoSuplementoCM::find($id);
        $obj->delete();
        return redirect()->back()->with('status', 'Objeto eliminado satisfactoriamente');
    }
}
