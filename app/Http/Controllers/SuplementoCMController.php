<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarco;
use App\Models\EntidadSuplementoObjCM;
use App\Models\ObjetoSuplementoCM;
use App\Models\SuplementoCM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuplementoCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sup = SuplementoCM::paginate(50);
        $objetos = EntidadSuplementoObjCM::all();
        $links = true;

        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        return view('suplemento_CM.index', compact('Sup','links','objetos', 'now', 'ThreeDaysearly'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $CM = ContratoMarco::find($id);
        $entidadObjSup = EntidadSuplementoObjCM::all();
        $obj= ObjetoSuplementoCM::all();
        return view('suplemento_CM.create', compact('CM','entidadObjSup','obj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'fecha' => 'required',
            'fechaEnd' => 'required',
            'ejecutor' => 'required',
            'objs' => 'required'
        ],[
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'fecha.required' => 'Tiene que introducir una fecha de inicio',
            'ejecutor.required' => 'Tiene que introducir el nombre del ejecutor',
            'objs.required' => 'Tiene que seleccionar uno o más objetos de suplementos'
        ]);

        $noSup = count(SuplementoCM::where('idCMSuplemto', $request->input('noContrato'))->get());

        $SUP = new SuplementoCM();
        $SUP->idCMSuplemto = $request->input('noContrato');
        $SUP->noSupCM = $noSup + 1;
        $SUP->fechaIniSup = $request->input('fecha');
        $SUP->fechaEndSup = $request->input('fechaEnd');
        $SUP->ejecutorSup = $request->input('ejecutor');
        $SUP->observacionesSup = $request->input('observaciones');
        $SUP->save($validatedData);

        $lastSup = SuplementoCM::latest('id')->first();

        $objs= $request->input('objs');
        for ($i=0; $i < count($objs); $i++) { 
           $EntidadSupObjCM = new EntidadSuplementoObjCM();
           $EntidadSupObjCM ->idObjCM = $objs[$i];
           $EntidadSupObjCM ->idSupCM = $lastSup->id;
           $EntidadSupObjCM ->save();
        }

        return redirect()->back()->with('status', 'Suplemento de Contrato Marco añadido satisfactoriamente');
        
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
        $Sup= SuplementoCM::where('idCMSuplemto', $id)->get();
        $objetos = EntidadSuplementoObjCM::all();

        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        $links = false;
        return view('suplemento_CM.detail', compact('CM','Sup','objetos','links','ThreeDaysearly','now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Sup = SuplementoCM::where('id',$id)->get();
        $selectedObjs = EntidadSuplementoObjCM::where('idSupCM',$id)->get();
        $obj = ObjetoSuplementoCM::all();
        //dd($selectedServ);
        return view('suplemento_CM.edit', compact('Sup','selectedObjs','obj'));
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
            'fecha' => 'required',
            'fechaEnd' => 'required',
            'ejecutor' => 'required',
            'objs' => 'required'
        ],[
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'fecha.required' => 'Tiene que introducir una fecha de inicio',
            'ejecutor.required' => 'Tiene que introducir el nombre del ejecutor',
            'objs.required' => 'Tiene que seleccionar uno o más objetos de suplementos'
        ]);

        $SUP = SuplementoCM::find($id);
        $SUP->idCMSuplemto = $request->input('noContrato');
        $SUP->fechaIniSup = $request->input('fecha');
        $SUP->fechaEndSup = $request->input('fechaEnd');
        $SUP->ejecutorSup = $request->input('ejecutor');
        $SUP->observacionesSup = $request->input('observaciones');
        $SUP->update($validatedData);

        $oldObjs = EntidadSuplementoObjCM::where('idSupCM', $id)->get();
        for ($i=0; $i < count($oldObjs); $i++) { 
            $del= EntidadSuplementoObjCM::find($oldObjs[$i]->id);
            $del->delete();
        }

        $aux = array_unique($request->input('objs'));

        $objetos = array_values($aux);

        //dd($services);
        for ($i=0; $i < count($objetos); $i++) { 
           $EntidadSupObj = new EntidadSuplementoObjCM();
           $EntidadSupObj->idSupCM = $id;
           $EntidadSupObj->idObjCM = $objetos[$i];
           $EntidadSupObj->save();
        }

        
        return redirect()->back()->with('status', 'Suplemeto de Contrato Marco editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldObjs= EntidadSuplementoObjCM::where('idSupCM', $id)->get();
        for ($i=0; $i < count($oldObjs); $i++) { 
            $del= EntidadSuplementoObjCM::find($oldObjs[$i]->id);
            $del->delete();
        }
        $Sup = SuplementoCM::find($id)->delete(); 
        return redirect()->back()->with('status', 'Suplemento de Contrato Marco eliminado satisfactoriamente');
    }
}
