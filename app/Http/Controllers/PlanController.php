<?php

namespace App\Http\Controllers;

use App\Models\entidad;
use App\Models\indicador;
use App\Models\plan;
use App\Models\producto;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plan = plan::paginate(10);
        return view('plan.index',compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = 'none';
        $indicador = indicador::all();
        $entidad = entidad::all();
        $producto = producto::all();
        return view('plan.edit', compact('plan', 'indicador', 'entidad', 'producto'));
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
            'plan' => 'required',
            'year' => 'required|integer',
            'producto' => 'required',
            'indicador' => 'required',
            'entidad' => 'required'
        ], [
            'required' => 'Este campo es requerido',
            'year.integer' => 'Tiene que introducir un año válido'
        ]);

        $plan = new plan();
        $plan->plan = $request->input('plan');
        $plan->year = $request->input('year');
        $plan->producto_id = $request->input('producto');
        $plan->indicador_id = $request->input('indicador');
        $plan->entidad_id = $request->input('entidad');
        $plan->save($validatedData);
        return redirect('/plan')->with('status','Plan creado satisfactoriamente');
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
        $plan = plan::find($id);
        $indicador = indicador::all();
        $entidad = entidad::all();
        $producto = producto::all();
        return view('plan.edit', compact('plan', 'indicador', 'entidad', 'producto'));
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
            'plan' => 'required',
            'year' => 'required|integer',
            'producto' => 'required',
            'indicador' => 'required',
            'entidad' => 'required'
        ], [
            'required' => 'Este campo es requerido',
            'year.integer' => 'Tiene que introducir un año válido'
        ]);

        $plan = plan::find($id);
        $plan->plan = $request->input('plan');
        $plan->year = $request->input('year');
        $plan->producto_id = $request->input('producto');
        $plan->indicador_id = $request->input('indicador');
        $plan->entidad_id = $request->input('entidad');
        $plan->update($validatedData);
        return redirect('/plan')->with('status','Plan editado satisfactoriamente');
    }

    public function delete($id)
    {
        $plan = plan::find($id);
        return view('plan.delete', compact('plan'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = plan::find($id);
        $plan->delete();
        return redirect()->back()->with('status','Plan eliminado Satisfactoriamente');
    }

    public function filter(Request $request)
    {
        $query = plan::query();

        $query->when(request()->input('planIni'), function($q) {
            return $q->where('plan', '>=',request()->input('planIni'));
        });
        $query->when(request()->input('planEnd'), function($q) {
            return $q->where('plan', '<=',request()->input('planEnd'));
        });
        $query->when(request()->input('yearIni'), function($q) {
            return $q->where('year', '>=',request()->input('yearIni'));
        });
        $query->when(request()->input('yearEnd'), function($q) {
            return $q->where('year', '<=',request()->input('yearEnd'));
        });

        $query->when(request()->input('entidades'), function($q) {

            return $q->whereHas('entidad', function($q)
            {
                $q->whereIn('entidad_id', request()->input('entidades'));
            });
        });

        $query->when(request()->input('productos'), function($q) {

            return $q->whereHas('producto', function($q)
            {
                $q->whereIn('producto_id', request()->input('productos'));
            });
        });

        $query->when(request()->input('indicadores'), function($q) {

            return $q->whereHas('indicador', function($q)
            {
                $q->whereIn('indicador_id', request()->input('indicadores'));
            });
        });

        $plan = $query->paginate(10);
        $entidad = entidad::all();
        $producto = producto::all();
        $indicador = indicador::all();
        return view('plan.filter',compact('producto', 'entidad', 'indicador', 'plan'));
    }
}
