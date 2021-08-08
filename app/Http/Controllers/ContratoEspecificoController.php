<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ContratoEspecifico;
use App\Models\ContratoMarco;
use App\Models\EntidadAreaServico;
use App\Models\EntidadServicioContratoE;
use App\Models\Organismo;
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
        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        $CES = ContratoEspecifico::all();
        for ($i=0; $i < count($CES); $i++) { 
            $endDate = Carbon::parse($CES[$i]->fechaEndCE)->format('d-m-y');
            $fechaEnd = Carbon::createFromFormat('d-m-y', $endDate);

            $actual = Carbon::now()->format('d-m-y');
            $RightNow = Carbon::createFromFormat('d-m-y',$actual);
            //dd($RightNow);
            //dd($fechaEnd);
            //dd($RightNow->gte($fechaEnd));
            if($fechaEnd->lte($RightNow)){
                $contrato = ContratoEspecifico::where('idCEspecifico', $CES[$i]->idCEspecifico);
                if($contrato){
                    //$contrato[0]->estado = 'Terminado';
                    //$contrato[0]->update();
                    $contrato->update(['estado' => 'Terminado']);
                }
            }
         }
        $CE = ContratoEspecifico::paginate(50);
        $servicios = EntidadServicioContratoE::all();
        $organismos = Organismo::all();
        $area = Area::all();
        $links = true;
        return view('contratos_especificos.index', compact('CE','now','ThreeDaysearly','servicios','organismos','area','links'));
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
            'ejecutorName' => 'required',
            'clienteName' => 'required',
            'area' => 'required',
            'services' => 'required'
        ],[
            'fechaIni.required' => 'Tiene que introducir una fecha de inicio',
            'ejecutorName.required' => 'Tiene que introducir el nombre del prestador',
            'clienteName.required' => 'Tiene que introducir el nombre del cliente',
            'area.required' => 'Tiene que seleccionar un área',
            'services.required' => 'Tiene que seleccionar uno o más servicios'
        ]);

        $fechaFinal = $request->input('fechaEnd');
        if($fechaFinal == null){
            $fechaEnd = Carbon::parse($request->input('fechaIni'))->format('d-m-YY');
            $fechaEnd2 = Carbon::createFromFormat('d-m-YY',$fechaEnd);
            $fechaEnd3 = $fechaEnd2->addYear(1)->format('d-m-Y');
           // dd($fechaEnd3);
        }
        else{
            $fechaEnd3 = $request->input('fechaEnd');
        }

        $noCE = count(ContratoEspecifico::where('idCM', $request->input('noContrato'))->get());

        $CE = new ContratoEspecifico();
        $CE->idCM = $request->input('noContrato');
        $CE->idAreaCE = $request->input('area');
        $CE->noContratoEspecifico = $noCE + 1;
        $CE->estado = $request->input('estado');
        $CE->fechaIniCE = $request->input('fechaIni');
        $CE->fechaEndCE = $fechaEnd3;
        $CE->ejecutorname = $request->input('ejecutorName');
        $CE->clienteName = $request->input('clienteName');
        $CE->observaciones = $request->input('observaciones');
        $CE->monto = $request->input('monto');
        $CE->save($validatedData);

        $lastCE = ContratoEspecifico::latest('idCEspecifico')->first();

        $services = $request->input('services');
        for ($i=0; $i < count($services); $i++) { 
           $EntidadSCE = new EntidadServicioContratoE();
           $EntidadSCE->idServicioS = $services[$i];
           $EntidadSCE->idContratoEspecifico = $lastCE->idCEspecifico;
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
        
        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        $servicios = EntidadServicioContratoE::all();
        $organismos = Organismo::all();
        $area = Area::all();
        return view('contratos_especificos.detail', compact('CE','now','ThreeDaysearly','CM','servicios','organismos','area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contratoE = ContratoEspecifico::where('idCEspecifico',$id)->get();
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

        //$CE = ContratoEspecifico::where('idCEspecifico',$id)->first();
        /*$CE = ContratoEspecifico::where('idCEspecifico',$id)->first();
        $CE->idCM = $request->input('noContrato');
        $CE->idAreaCE = $request->input('area');
        $CE->estado = $request->input('estado');
        $CE->fechaIniCE = $request->input('fechaIni');
        $CE->fechaEndCE = $request->input('fechaEnd');
        $CE->ejecutorName = $request->input('ejecutorName');
        $CE->clienteName = $request->input('clienteName');
        $CE->observaciones = $request->input('observaciones');
        $CE->monto = $request->input('monto');
        $CE->update($validatedData);*/

        $CE = ContratoEspecifico::where('idCEspecifico',$id)
              ->update(['idCM' => $request->input('noContrato'),
               'idAreaCE' => $request->input('area'),
               'estado' => $request->input('estado'),
               'fechaIniCE' => $request->input('fechaIni'),
               'fechaEndCE' => $request->input('fechaEnd'),
               'ejecutorName' => $request->input('ejecutorName'),
               'clienteName' => $request->input('clienteName'),
               'observaciones' => $request->input('observaciones'),
               'monto' => $request->input('monto')
            ]);
        //dd($request->input('services'));

        $oldServcices = EntidadServicioContratoE::where('idContratoEspecifico', $id)->get();
        for ($i=0; $i < count($oldServcices); $i++) { 
            $del= EntidadServicioContratoE::find($oldServcices[$i]->id);
            $del->delete();
        }

        $aux = array_unique($request->input('services'));

        $services = array_values($aux);

        //dd($services);
        for ($i=0; $i < count($services); $i++) { 
           $EntidadSCE = new EntidadServicioContratoE();
           $EntidadSCE->idServicioS = $services[$i];
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
        //DB::table('users')->where('votes', '>', 100)->delete();
        $CE = ContratoEspecifico::where('idCEspecifico',$id)->delete(); 
        return redirect()->back()->with('status', 'Contrato Específico eliminado satisfactoriamente');
    }
}
