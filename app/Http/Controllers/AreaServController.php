<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\entidadAreaServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;

class AreaServController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Servicio::query();

        $query->when(request()->input('servCod'), function ($q) {
            return $q->where('codigo', 'like', '%' . request()->input('servCod') . '%');
        });

        $query->when(request()->input('serv_id'), function ($q) {
            $q->where('idservicio', request()->input('serv_id'));
        });

        $query->when(request()->input('area_id'), function ($q) {
            $q->whereHas('AreaServicio', function ($q) {
                $q->whereHas('area', function ($q) {
                    return $q->where('idarea', request()->input('area_id'));
                });
            });
        });

        $servicios = $query->paginate(30);
        $servicioSelect = Servicio::all();
        $areasSelect = Area::where('activa', 1)->get();

        return view('areaServ.index', compact('areasSelect', 'servicios', 'servicioSelect'));
    }

    public function getServicioByArea(Request $request)
    {
        $query = entidadAreaServicio::query();
        $query->where('area_id', request()->input('area_id'));


        $servicios = $query->join("dbo.ServicesView", 'dbo.ServicesView.idservicio', '=', 'servicio_id')->pluck("Descripcion", "idservicio");
        return response()->json($servicios);
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
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'area_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);



        $servArea = new entidadAreaServicio();
        $servArea->area_id = $request->input('area_id');
        $servArea->servicio_id = $id;
        $servArea->save($validatedData);
        return redirect('/areaserv')->with('status', 'Servicio editado satisfactoriamente');
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
        $servicio = entidadAreaServicio::where('servicio_id', $id)->get();
        $serv = 'none';
        if (count($servicio) === 0) {
            $servicio = 'none';
            $serv = Servicio::where('idservicio', $id)->get();
        }
        $areas = Area::where('activa', 1)->get();
        return view('areaServ.edit', compact('areas', 'servicio', 'serv'));
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
            'area_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);



        $servArea = entidadAreaServicio::find($id);
        $servArea->area_id = $request->input('area_id');
        $servArea->update($validatedData);
        return redirect('/areaserv')->with('status', 'Servicio editado satisfactoriamente');
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
