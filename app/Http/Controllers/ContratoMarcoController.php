<?php

namespace App\Http\Controllers;

use App\Models\CMfile;
use App\Models\ContratoMarco;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\ObjetoCM;
use App\Models\Organismo;
use App\Models\EntidadGO;
use App\Rules\noOrganismo;
use Carbon\Carbon;

class ContratoMarcoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CM = ContratoMarco::paginate(50);
        $CMS = ContratoMarco::all();

        //$last = ContratoMarco::latest()->first();
        $now2 = Carbon::now()->format('d-m-y');
        $now = Carbon::createFromFormat('d-m-y',$now2);

        $ThreeDaysearly2 = Carbon::now()->addMonth(3)->format('d-m-y');
        $ThreeDaysearly = Carbon::createFromFormat('d-m-y',$ThreeDaysearly2);

        for ($i=0; $i < count($CMS); $i++) { 
            $endDate = Carbon::parse($CMS[$i]->fechaEnd)->format('d-m-y');
            $fechaEnd = Carbon::createFromFormat('d-m-y', $endDate);

            $actual = Carbon::now()->format('d-m-y');
            $RightNow = Carbon::createFromFormat('d-m-y',$actual);
            //dd($RightNow);
            //dd($fechaEnd);
            //dd($RightNow->gte($fechaEnd));
            if($fechaEnd->lte($RightNow)){
                $contrato = ContratoMarco::find($CMS[$i]->id);
                $contrato->estado = 'Vencido';
                $contrato->update();
            }
         }
        
        $organismos = Organismo::all();
        $objeto = ObjetoCM::all();
        $links = true;
        return view('contratos_marco.index',compact('CM','now','ThreeDaysearly','organismos','objeto','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objeto = ObjetoCM::all();
        $organismos = Organismo::all();
        return view('contratos_marco.create',compact('objeto','organismos'));
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
            'organismo' =>  ['required', new noOrganismo()],
            'cliente' => 'required',
            'estado' => 'required',
            'nombreContacto' => 'required',
            'emailContacto' => 'required',
            'elaboradoPor' => 'required',
            'fechaIni' => 'required|date|before:fechaEnd',
            'fechaEnd' => 'required|date|after:fechaIni'
        ],[
            'objeto.required' => "Tiene que seleccioanr un objeto",
            'organismo.required' => "Tiene que seleccionar un organismo",
            'cliente.required' => 'Tiene que seleccionar un cliente',
            'estado.required' => 'Tiene que especificar un estado',
            'nombreContacto.required' => 'Tiene que introducir el nombre del contacto',
            'emailContacto.required' => 'Tiene que introducir el email del contacto',
            'elaboradoPor.required' => 'Tiene que espesificar por quién fue elaborado',
            'fechaIni.required' => 'Tiene que seleccioanr una fecha de firma',
            'fechaEnd.required' => 'Tiene que seleccioanr una fecha de vencimiento',
            'fechaIni.before' => 'La fecha de inicio tiene que ser menor que la fecha de vencimiento',
            'fechaEnd.after' => 'La fecha de vencimiento tiene que ser mayor que la fecha de inicio',
        ]);

        $last = ContratoMarco::latest('id')->first();
        if($last != null){
            $aux = $last->noContrato;
            $lastArr = explode("/",$aux);
        }
        $newYear = $request->input('fechaIni');

        if($last != null && $lastArr[1] == Carbon::createFromFormat('d-m-Y', $newYear)->format('Y')){
            $noContract = $lastArr[0] + 1 .'/'.$lastArr[1];
        }
        else{
            $noContract = 1 .'/'.Carbon::createFromFormat('d-m-Y', $newYear)->format('Y');
        }
        //dd($noContract);

        $fechaFinal = $request->input('fechaEnd');
        if($fechaFinal == null){
            $fechaEnd = Carbon::parse($request->input('fechaIni'))->format('d-m-YY');
            $fechaEnd2 = Carbon::createFromFormat('d-m-YY',$fechaEnd);
            $fechaEnd3 = $fechaEnd2->addYear(5)->format('d-m-Y');
           // dd($fechaEnd3);
        }
        else{
            $fechaEnd3 = $request->input('fechaEnd');
        }

        //$paymentDate = '05/06/2021';
        $CM = new ContratoMarco();
        $CM->noContrato = $noContract;
        $CM->objeto = $request->input('objeto');
        $CM->organismo = $request->input('organismo');
        $CM->grupo = $request->input('grupo');
        $CM->idClient = $request->input('cliente');
        $CM->estado = $request->input('estado');
        $CM->fechaIni = $request->input('fechaIni');
        $CM->fechaEnd = $fechaEnd3;
        $CM->nombreContacto = $request->input('nombreContacto');
        $CM->emailContacto = $request->input('emailContacto');
        $CM->elaboradoPor = $request->input('elaboradoPor');
        $CM->observaciones = $request->input('observaciones');
        $CM->save($validatedData);
        //dd($CM);
        return redirect()->back()->with('status', 'Contrato Marco añadido satisfactoriamente');

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
        //$entidad= DB::table('dbo.ClientsView')->where('identidad', '1')->get();
        $contrato = ContratoMarco::find($id);
        $GO = EntidadGO::where('idClientGO', $contrato->idClient)->get();
        $organismos = Organismo::all();
        $objeto = ObjetoCM::all();
        //dd($Organismo);
        return view('contratos_marco.edit', compact('contrato','GO', 'organismos','objeto'));
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
            'organismo' =>  ['required', new noOrganismo()],
            'cliente' => 'required',
            'estado' => 'required',
            'nombreContacto' => 'required',
            'emailContacto' => 'required',
            'elaboradoPor' => 'required',
            'fechaIni' => 'required|date|before:fechaEnd',
            'fechaEnd' => 'required|date|after:fechaIni'
        ],[
            'objeto.required' => "Tiene que seleccioanr un objeto",
            'organismo.required' => "Tiene que seleccionar un organismo",
            'cliente.required' => 'Tiene que seleccionar un cliente',
            'estado.required' => 'Tiene que especificar un estado',
            'nombreContacto.required' => 'Tiene que introducir el nombre del contacto',
            'emailContacto.required' => 'Tiene que introducir el email del contacto',
            'elaboradoPor.required' => 'Tiene que espesificar por quién fue elaborado',
            'fechaIni.required' => 'Tiene que seleccioanr una fecha de firma',
            'fechaEnd.required' => 'Tiene que seleccioanr una fecha de vencimiento',
            'fechaIni.before' => 'La fecha de inicio tiene que ser menor que la fecha de vencimiento',
            'fechaEnd.after' => 'La fecha de vencimiento tiene que ser mayor que la fecha de inicio',
        ]);


        $CM = ContratoMarco::find($id);
        $year = explode("/",$CM->noContrato);
        $CMF = CMfile::where('id_CM', $CM->id)->get();
        //dd($CM->noContrato);
        if (count($CMF) == 0) {
            $CMF = new CMfile();
            if($request->hasFile('file1')){
                $file1 = $request->file('file1');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file1Name= '1-' . $year[0] . '-' . $year[1] . "." . $file1->getClientOriginalExtension();
                $file1->move(storage_path('app/public/' . $destinationPath), $file1Name);
                $CMF->id_CM = $CM->id;
                $CMF->file1 = $file1;
            }
            if($request->hasFile('file2')){
                $file2 = $request->file('file2');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file2Name= '2-' . $year[0] . '-' . $year[1] . "." . $file2->getClientOriginalExtension();
                $file2->move(storage_path('app/public/' . $destinationPath), $file2Name);
                $CMF->id_CM = $CM->id;
                $CMF->file2 = $file2;
            }
            if($request->hasFile('file3')){
                $file3 = $request->file('file3');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file3Name= '3-' . $year[0] . '-' . $year[1] . "." . $file3->getClientOriginalExtension();
                $file3->move(storage_path('app/public/' . $destinationPath), $file3Name);
                $CMF->id_CM = $CM->id;
                $CMF->file3 = $file3;
            }
            if($request->hasFile('file4')){
                $file4 = $request->file('file4');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file4Name= '4-' . $year[0] . '-' . $year[1] . "." . $file4->getClientOriginalExtension();
                $file4->move(storage_path('app/public/' . $destinationPath), $file4Name);
                $CMF->id_CM = $CM->id;
                $CMF->file4 = $file4;
            }
            if($request->hasFile('file1') || $request->hasFile('file2') || $request->hasFile('file3') || $request->hasFile('file4')){
                $CMF->path = $destinationPath;
                $CM->idFile = $destinationPath;;
                $CMF->save();
            }
        }
        else{
            if($request->hasFile('file1')){
                $file1 = $request->file('file1');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];
                $file1Name= '1-' . $year[0] . '-' . $year[1] . "." . $file1->getClientOriginalExtension();
                $file1->move(storage_path('app/public/' . $destinationPath), $file1Name);
                $CMF[0]->id_CM = $CM->id;
                $CMF[0]->file1 = $file1;
            }
            if($request->hasFile('file2')){
                $file2 = $request->file('file2');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file2Name= '2-' . $year[0] . '-' . $year[1] . "." . $file2->getClientOriginalExtension();
                $file2->move(storage_path('app/public/' . $destinationPath), $file2Name);
                $CMF[0]->id_CM = $CM->id;
                $CMF[0]->file2 = $file2;
            }
            if($request->hasFile('file3')){
                $file3 = $request->file('file3');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file3Name= '3-' . $year[0] . '-' . $year[1] . "." . $file3->getClientOriginalExtension();
                $file3->move(storage_path('app/public/' . $destinationPath), $file3Name);
                $CMF[0]->id_CM = $CM->id;
                $CMF[0]->file3 = $file3;
            }
            if($request->hasFile('file4')){
                $file4 = $request->file('file4');
                $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];//'1-' . $CM->noContrato .
                $file4Name= '4-' . $year[0] . '-' . $year[1] . "." . $file4->getClientOriginalExtension();
                $file4->move(storage_path('app/public/' . $destinationPath), $file4Name);
                $CMF[0]->id_CM = $CM->id;
                $CMF[0]->file4 = $file4;
            }
            if($request->hasFile('file1') || $request->hasFile('file2') || $request->hasFile('file3') || $request->hasFile('file4')){
                $CMF[0]->path = $destinationPath;
                $CM->idFile = $destinationPath;
                $CMF[0]->update();
            }
        }


        //$CM->noContrato = $request->input('codigo');
        $CM->objeto = $request->input('objeto');
        $CM->organismo = $request->input('organismo');
        $CM->grupo = $request->input('grupo');
        $CM->idClient = $request->input('cliente');
        $CM->estado = $request->input('estado');
        $CM->fechaIni = $request->input('fechaIni');
        $CM->fechaEnd = $request->input('fechaEnd');
        $CM->nombreContacto = $request->input('nombreContacto');
        $CM->emailContacto = $request->input('emailContacto');
        $CM->elaboradoPor = $request->input('elaboradoPor');
        $CM->observaciones = $request->input('observaciones');
        $CM->update($validatedData);
        //dd($CM);
        return redirect()->back()->with('status', 'Contrato Marco editado satisfactoriamente');
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
