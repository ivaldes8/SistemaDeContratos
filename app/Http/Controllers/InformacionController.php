<?php

namespace App\Http\Controllers;

use App\Exports\InformacionExport;
use App\Imports\InformacionEntidadCpcuSaclapImport;
use App\Models\actividad;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\indicador;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\producto;
use App\Models\saclap;
use App\Models\unidad;
use App\Models\informacionEntidadCpcuSaclap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InformacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $productos = producto::all();
        $cpcus = cpcu::all();
        $saclaps = saclap::all();
        $entidades = entidad::all();
        $unidades = unidad::all();
        $actividades = actividad::all();
        $indicadores = indicador::all();

        $query = informacionEntidadCpcuSaclap::query();

        $query->when(request()->input('producto'), function($q) {
            $q->whereHas('cpcu', function($q)
                {
                    $q->whereHas('productos', function($q) {
                        return $q->where('producto_id',request()->input('producto'));
                    });
                })->orWhereHas('saclap', function($q)
                {
                    $q->whereHas('productos', function($q) {
                        return $q->where('producto_id',request()->input('producto'));
                    });
                });
        });

        $query->when(request()->input('cpcu'), function($q) {
            $q->where('cpcu_id',request()->input('cpcu'));
        });

        $query->when(request()->input('saclap'), function($q) {
            $q->where('saclap_id',request()->input('saclap'));
        });

        $query->when(request()->input('entidad'), function($q) {
            return $q->where('entidad_id',request()->input('entidad'));
        });

         $query->when(request()->input('actividad'), function($q) {
            $q->whereHas('cpcu', function($q)
                {
                    $q->whereHas('productos', function($q) {
                        $q->whereHas('actividades', function($q){
                            return $q->where('actividad_id',request()->input('actividad'));
                        });
                    });
                })->orWhereHas('saclap', function($q)
                {
                    $q->whereHas('actividades', function($q){
                        return $q->where('actividad_id',request()->input('actividad'));
                    });
                });
        });

        $query->when(request()->input('unidad'), function($q) {
            return $q->where('unidad_id',request()->input('unidad'));
        });

        $query->when(request()->input('indicador'), function($q) {
            return $q->where('indicador_id',request()->input('indicador'));
        });

        $query->when(request()->input('valorIni'), function($q) {
            return $q->where('value','>=',request()->input('valorIni'));
        });

        $query->when(request()->input('valorEnd'), function($q) {
            return $q->where('value','<=',request()->input('valorEnd'));
        });

        $query->when(request()->input('fechaIni'), function($q) {
            return $q->whereDate('date','>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIni'))->toDateString());
        });

        $query->when(request()->input('fechaEnd'), function($q) {
            return $q->whereDate('date','<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEnd'))->toDateString());
        });

        $informacion = $query->orderBy('date','ASC')->paginate(50);

        $EntitiesValidation = null;

        $ent = informacionEntidadCpcuSaclap::where('entidad_id', null)->get();

        if(count($ent) > 0) {
            $EntitiesValidation = 'Existen '. count($ent) .' registros con productos sin entidades asignadas, esto prodría afectar en el cálculo de algunos parámetros de la aplicación.';
        }

        return view('informacion.index',compact('informacion', 'productos', 'cpcus', 'saclaps', 'entidades', 'unidades', 'actividades', 'indicadores', 'EntitiesValidation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $informacion = 'none';
        $entidades = entidad::all();
        $indicadores = indicador::all();
        $unidades = unidad::all();
        $cpcu = cpcu::all();
        $saclap = saclap::all();

        return view('informacion.edit', compact('informacion', 'cpcu', 'saclap', 'entidades', 'indicadores', 'unidades'));
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
            'indicador' => 'required',
            'valor' => 'required',
            'unidad' => 'required',
            'fecha' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);


        if(!$request->input('cpcu') && !$request->input('saclap')){
            return back()->withErrors(["CpcuSaclap" => ["Tiene que seleccionar un código cpcu o un código saclap"]]);
        }

        $informacion = new informacionEntidadCpcuSaclap();
        $informacion->cpcu_id = $request->input('cpcu');
        $informacion->saclap_id = $request->input('saclap');
        $informacion->entidad_id = $request->input('entidad');
        $informacion->indicador_id = $request->input('indicador');
        $informacion->value = $request->input('valor');
        $informacion->unidad_id = $request->input('unidad');
        $informacion->date = Carbon::createFromFormat('Y-m-d', $request->input('fecha'))->toDateString();
        $informacion->save($validatedData);
        return redirect('/informacion')->with('status','Infomación creada satisfactoriamente');
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
        $informacion = informacionEntidadCpcuSaclap::find($id);
        $cpcu = cpcu::all();
        $saclap = saclap::all();
        $entidades = entidad::all();
        $indicadores = indicador::all();
        $unidades = unidad::all();
        return view('informacion.edit', compact('informacion', 'cpcu', 'saclap', 'entidades', 'indicadores', 'unidades'));
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
            'indicador' => 'required',
            'valor' => 'required',
            'unidad' => 'required',
            'fecha' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        if(!$request->input('cpcu') && !$request->input('saclap')){
            return back()->withErrors(["CpcuSaclap" => ["Tiene que seleccionar un código cpcu o un código saclap"]]);
        }

        $informacion = informacionEntidadCpcuSaclap::find($id);
        $informacion->cpcu_id = $request->input('cpcu');
        $informacion->saclap_id = $request->input('saclap');
        $informacion->entidad_id = $request->input('entidad');
        $informacion->indicador_id = $request->input('indicador');
        $informacion->value = $request->input('valor');
        $informacion->unidad_id = $request->input('unidad');
        $informacion->date = Carbon::createFromFormat('Y-m-d', $request->input('fecha'))->toDateString();
        $informacion->update($validatedData);
        return redirect('/informacion')->with('status','Infomación editada satisfactoriamente');
    }

    public function delete($id)
    {
        $informacion = informacionEntidadCpcuSaclap::find($id);
        return view('informacion.delete', compact('informacion'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informacion = informacionEntidadCpcuSaclap::find($id);
        $informacion->delete();
        return redirect()->back()->with('status','Información eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('informacion.file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
        Excel::import(new InformacionEntidadCpcuSaclapImport,request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new InformacionExport, 'informacion.xlsx');
    }
}
