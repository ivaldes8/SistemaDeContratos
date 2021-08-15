<?php

namespace App\Http\Controllers;

use App\Models\ContratoEspecifico;
use App\Models\EntidadSuplementoObjCE;
use App\Models\ObjetoSuplementoCE;
use App\Models\SuplementoCE;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuplementoCEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sup = SuplementoCE::paginate(50);
        $objetos = EntidadSuplementoObjCE::all();

        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        $links = true;
        return view('suplemento_CE.index', compact('Sup','links','objetos','ThreeDaysearly','now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $CE = ContratoEspecifico::where('idCEspecifico', $id)->get();
        $entidadObjSup = EntidadSuplementoObjCE::all();
        $obj= ObjetoSuplementoCE::all();
        return view('suplemento_CE.create', compact('CE','entidadObjSup','obj'));
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
            'fecha' => 'required|date|before:fechaEnd',
            'fechaEnd' => 'required|date|after:fecha|before:fechaEndCE',
            'ejecutor' => 'required',
            'objs' => 'required'
        ],[
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'fecha.required' => 'Tiene que introducir una fecha de inicio',
            'fechaEnd.after' => 'La fecha de vencimiento tiene que ser mayor que la fecha de inicio',
            'fechaEnd.before' =>  'La fecha de vencimiento del Suplemento no puede ser mayor que la fecha de vencimiento del Contrato Específico',
            'fecha.before' => 'La fecha de inicio tiene que ser menor que la fecha de vencimiento',
            'ejecutor.required' => 'Tiene que introducir el nombre del ejecutor',
            'objs.required' => 'Tiene que seleccionar uno o más objetos de suplementos'
        ]);

        $noSup = count(SuplementoCE::where('idCESuplemto', $request->input('noContrato'))->get());

        $SUP = new SuplementoCE();
        $SUP->idCESuplemto = $request->input('noContrato');
        $SUP->noSupCE = $noSup + 1;
        $SUP->fechaIniSup = $request->input('fecha');
        $SUP->fechaEndSup = $request->input('fechaEnd');
        $SUP->ejecutorSup = $request->input('ejecutor');
        $SUP->observacionesSup = $request->input('observaciones');
        $SUP->save($validatedData);

        $lastSup = SuplementoCE::latest('id')->first();

        $objs= $request->input('objs');
        for ($i=0; $i < count($objs); $i++) { 
           $EntidadSupObjCE = new EntidadSuplementoObjCE();
           $EntidadSupObjCE ->idObjCE = $objs[$i];
           $EntidadSupObjCE ->idSupCE = $lastSup->id;
           $EntidadSupObjCE->save();
        }

        return redirect()->back()->with('status', 'Suplemento de Contrato Específico añadido satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CE = ContratoEspecifico::where('idCEspecifico', $id)->get();
        $Sup= SuplementoCE::where('idCESuplemto', $id)->get();
        $objetos = EntidadSuplementoObjCE::all();

        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        $links = false;
        return view('suplemento_CE.detail', compact('CE','Sup','objetos','links','ThreeDaysearly','now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Sup = SuplementoCE::where('id',$id)->get();
        $CE = ContratoEspecifico::where('idCEspecifico',$Sup[0]->idCESuplemto)->get();
        $selectedObjs = EntidadSuplementoObjCE::where('idSupCE',$id)->get();
        $obj = ObjetoSuplementoCE::all();
        //dd($selectedServ);
        return view('suplemento_CE.edit', compact('CE','Sup','selectedObjs','obj'));
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
            'fecha' => 'required|date|before:fechaEnd',
            'fechaEnd' => 'required|date|after:fecha|before:fechaEndCE',
            'ejecutor' => 'required',
            'objs' => 'required'
        ],[
            'fechaEnd.required' => 'Tiene que introducir una fecha final',
            'fecha.required' => 'Tiene que introducir una fecha de inicio',
            'fechaEnd.after' => 'La fecha de vencimiento tiene que ser mayor que la fecha de inicio',
            'fechaEnd.before' =>  'La fecha de vencimiento del Suplemento no puede ser mayor que la fecha de vencimiento del Contrato Específico',
            'fecha.before' => 'La fecha de inicio tiene que ser menor que la fecha de vencimiento',
            'ejecutor.required' => 'Tiene que introducir el nombre del ejecutor',
            'objs.required' => 'Tiene que seleccionar uno o más objetos de suplementos'
        ]);

        $SUP = SuplementoCE::find($id);
        $SUP->idCESuplemto = $request->input('noContrato');
        $SUP->fechaIniSup = $request->input('fecha');
        $SUP->fechaEndSup = $request->input('fechaEnd');
        $SUP->ejecutorSup = $request->input('ejecutor');
        $SUP->observacionesSup = $request->input('observaciones');
        $SUP->update($validatedData);

        $oldObjs = EntidadSuplementoObjCE::where('idSupCE', $id)->get();
        for ($i=0; $i < count($oldObjs); $i++) { 
            $del= EntidadSuplementoObjCE::find($oldObjs[$i]->id);
            $del->delete();
        }

        $aux = array_unique($request->input('objs'));

        $objetos = array_values($aux);

        //dd($services);
        for ($i=0; $i < count($objetos); $i++) { 
           $EntidadSupObj = new EntidadSuplementoObjCE();
           $EntidadSupObj->idSupCE = $id;
           $EntidadSupObj->idObjCE = $objetos[$i];
           $EntidadSupObj->save();
        }

        
        return redirect()->back()->with('status', 'Suplemeto de Contrato Específico editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldObjs= EntidadSuplementoObjCE::where('idSupCE', $id)->get();
        for ($i=0; $i < count($oldObjs); $i++) { 
            $del= EntidadSuplementoObjCE::find($oldObjs[$i]->id);
            $del->delete();
        }
        $Sup = SuplementoCE::find($id)->delete(); 
        return redirect()->back()->with('status', 'Suplemento de Contrato Específico eliminado satisfactoriamente');
    }
}
