<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\EntidadAreaServico;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios= Servicio::paginate(50);
        $entidadAS = EntidadAreaServico::all();
        $area = Area::all();
        $links = true;
        return view('servicio_area.index', compact('servicios','entidadAS','area','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $servicio = Servicio::where('idservicio', $id)->get();
        $entidadAS = EntidadAreaServico::where('idServicioS', $id)->get();
        $area = Area::all();
        //dd($Organismo);
        return view('servicio_area.edit', compact('servicio','entidadAS','area'));
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
        $idArea= $request->input('idArea');
        $idServicio = $id;
        $entidadAS = EntidadAreaServico::where('idServicioS', $id)->get();
        if(count($entidadAS) > 0){
            $entidadAS[0]->idAreaA = $idArea;
            $entidadAS[0]->idServicioS = $idServicio;
            $entidadAS[0]->update();
            return redirect()->back()->with('status', 'Servicio editado satisfactoriamente');
        }
        else{
            $newEntidadAS = new EntidadAreaServico();
            $newEntidadAS->idAreaA = $idArea;
            $newEntidadAS->idServicioS = $idServicio;
            $newEntidadAS->save();
            return redirect()->back()->with('status', 'Servicio añadido satisfactoriamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
