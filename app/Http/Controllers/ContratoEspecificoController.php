<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ContratoEspecifico;
use App\Models\ContratoMarco;
use App\Models\EntidadAreaServico;
use App\Models\EntidadServicioContratoE;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContratoEspecificoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CE = ContratoEspecifico::all();
        $now = Carbon::now()->format('d-m-y');
        $ThreeDaysearly = Carbon::now()->addDays(3)->format('d-m-y');
        $servicios = EntidadServicioContratoE::all();
        return view('contratos_especificos.index', compact('CE','now','ThreeDaysearly','servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //dd($id);
        $CM = ContratoMarco::find($id);
        $area = Area::all();
        $entidadAS = EntidadAreaServico::all();
        $servicios= Servicio::all();
        return view('contratos_especificos.create', compact('CM','area','entidadAS','servicios'));
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
            'fechaIni' => 'required',
            'fechaEnd' => 'required',
            'ejecutorName' => 'required',
            'clienteName' => 'required',
            'area' => 'required',
            'services' => 'required'
        ],[
            'fechaIni.required' => 'Tiene que introducir una fecha de inicio',
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'ejecutorName.required' => 'Tiene que introducir el nombre del prestador',
            'clienteName.required' => 'Tiene que introducir el nombre del cliente',
            'area.required' => 'Tiene que seleccionar un área',
            'services.required' => 'Tiene que seleccionar uno o más servicios'
        ]);
        

        $noCE = count(ContratoEspecifico::where('idCM', $request->input('noContrato'))->get());

        $CE = new ContratoEspecifico();
        $CE->idCM = $request->input('noContrato');
        $CE->idArea = $request->input('area');
        $CE->noContratoEspecifico = $noCE + 1;
        $CE->estado = $request->input('estado');
        $CE->fechaIni = $request->input('fechaIni');
        $CE->fechaEnd = $request->input('fechaEnd');
        $CE->ejecutorname = $request->input('ejecutorName');
        $CE->clienteName = $request->input('clienteName');
        $CE->observaciones = $request->input('observaciones');
        $CE->monto = $request->input('monto');
        $CE->save($validatedData);

        $lastCE = ContratoEspecifico::latest('id')->first();

        $services = $request->input('services');
        for ($i=0; $i < count($services); $i++) { 
           $EntidadSCE = new EntidadServicioContratoE();
           $EntidadSCE->idServicio = $services[$i];
           $EntidadSCE->idContratoEspecifico = $lastCE->id;
           $EntidadSCE->save();
        }

        return redirect()->back()->with('status', 'Contrato Específico añadido satisfactoriamente');
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CM = ContratoMarco::find($id);
        $CE = ContratoEspecifico::where('idCM', $id)->get();
        $now = Carbon::now()->format('d-m-y');
        $ThreeDaysearly = Carbon::now()->addDays(3)->format('d-m-y');
        $servicios = EntidadServicioContratoE::all();
        return view('contratos_especificos.detail', compact('CE','now','ThreeDaysearly','CM','servicios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contratoE = ContratoEspecifico::find($id);
        $selectedServ = EntidadServicioContratoE::where('idContratoEspecifico',$id)->get();
        $area = Area::all();
        $servicios= Servicio::all();
        $entidadAS = EntidadAreaServico::all();
        //dd($selectedServ);
        return view('contratos_especificos.edit', compact('contratoE','selectedServ','area','servicios','entidadAS'));
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
       // dd($request);
        $validatedData = $request->validate([
            'fechaIni' => 'required',
            'fechaEnd' => 'required',
            'ejecutorName' => 'required',
            'clienteName' => 'required',
            'area' => 'required',
            'services' => 'required'
        ],[
            'fechaIni.required' => 'Tiene que introducir una fecha de inicio',
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'ejecutorName.required' => 'Tiene que introducir el nombre del prestador',
            'clienteName.required' => 'Tiene que introducir el nombre del cliente',
            'area.required' => 'Tiene que seleccionar un área',
            'services.required' => 'Tiene que seleccionar uno o más servicios'
        ]);

        $CE = ContratoEspecifico::find($id);
        $CE->idCM = $request->input('noContrato');
        $CE->idArea = $request->input('area');
        $CE->estado = $request->input('estado');
        $CE->fechaIni = $request->input('fechaIni');
        $CE->fechaEnd = $request->input('fechaEnd');
        $CE->ejecutorName = $request->input('ejecutorName');
        $CE->clienteName = $request->input('clienteName');
        $CE->observaciones = $request->input('observaciones');
        $CE->monto = $request->input('monto');
        $CE->update($validatedData);

        $oldServcices = EntidadServicioContratoE::where('idContratoEspecifico', $id)->get();
        for ($i=0; $i < count($oldServcices); $i++) { 
            $del= EntidadServicioContratoE::find($oldServcices[$i]->id);
            $del->delete();
        }

        $aux = array_unique($request->input('services'));

        //dd($aux);
        $services = array_values($aux);

        //dd($services);
        for ($i=0; $i < count($services); $i++) { 
           $EntidadSCE = new EntidadServicioContratoE();
           $EntidadSCE->idServicio = $services[$i];
           $EntidadSCE->idContratoEspecifico = $id;
           $EntidadSCE->save();
        }

        
        return redirect()->back()->with('status', 'Contrato Específico editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldServcices = EntidadServicioContratoE::where('idContratoEspecifico', $id)->get();
        for ($i=0; $i < count($oldServcices); $i++) { 
            $del= EntidadServicioContratoE::find($oldServcices[$i]->id);
            $del->delete();
        }

        $CE = ContratoEspecifico::find($id);
        $CE->delete();
        return redirect()->back()->with('status', 'Contrato Específico eliminado satisfactoriamente');
    }
}
