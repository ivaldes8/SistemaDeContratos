<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteProveedor;
use App\Models\EntidadCP;
use App\Models\GrupoEntidad;
use App\Models\Organismo;
use Illuminate\Support\Facades\DB;


class ClienteProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente_proveedor = ClienteProveedor::paginate(50);
        $CP = EntidadCP::all();
        $GO = GrupoEntidad::all();
        //dd($CP);
        return view('cliente_proveedor.index', compact('cliente_proveedor', 'CP', 'GO'));
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
    public function edit( $id )
    {
        //$entidad= DB::table('dbo.ClientsView')->where('identidad', '1')->get();
        $entidad = ClienteProveedor::where('identidad', $id)->get();

        $CP = EntidadCP::where('idClient',$id)->get();
        //dd($CP);
        return view('cliente_proveedor.edit', compact('entidad','CP'));
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
        $entidadCP = EntidadCP::where('idClient', $id)->get();
        if(count($entidadCP)>0){
            $entidadCP[0]->cliente = $request->input('tipo') == 'on' ? 'true' : 'false';
            $entidadCP[0]->proveedor = $request->input('proveedor') == 'on' ? 'true' : 'false';
            //dd($entidadCP);
            $entidadCP[0]->update();
            return redirect()->back()->with('status', 'Assignación editada satisfactoriamente');
        }
        else{
            $entidadCP = new EntidadCP();
            $entidadCP->idClient = $id;
            $entidadCP->cliente = $request->input('tipo') == 'on' ? 'true' : 'false';
            $entidadCP->proveedor = $request->input('proveedor') == 'on' ? 'true' : 'false';
            $entidadCP->save();
            return redirect()->back()->with('status', 'Asignación añadida satisfactoriamente');
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
