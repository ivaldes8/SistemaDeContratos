<?php

namespace App\Http\Controllers;
use App\Models\ClienteProveedor;
use App\Models\ContratoMarco;
use App\Models\EntidadCP;
use App\Models\EntidadGO;
use App\Models\Grupo;
use App\Models\Organismo;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function entidadSearch(Request $request){
        $codInt = $request->input('codInterno');
        $codReu = $request->input('codReu');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $cliente = $request->input('cliente');
        $proveedor = $request->input('proveedor');
        $organismo_id = $request->input('organismo_id');
        $grupo = $request->input('grupo');

        if($organismo_id == "1"){
            $organismo_id = null;
        }

        if($grupo == "1" || $grupo == "Grupo no seleccionado"){
            $grupo = null;
        }
        //$cliente_proveedor = ClienteProveedor::paginate(50);
        $CP = EntidadCP::all();
        $GO = EntidadGO::all();
        $grupos = Grupo::all();
        $organismos = Organismo::all();
        //dd($organismo_id);
        $BaseQuery = ClienteProveedor::query()
        ->join("entidad_c_p_s",'entidad_c_p_s.idClientCP', '=', 'identidad')
        ->join("entidad_g_o_s",'entidad_g_o_s.idClientGO', '=', 'identidad')
        ->join("grupos",'grupos.id', '=', 'idGrupo')
        ->join("organismos", 'organismos.id', '=', 'idOrganismo')
        ->get();

        $cliente_proveedor = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $cliente_proveedor->push($BaseQuery[$i]);
        }

        if ($cliente != null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->cliente, '1' )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
       //dd($request);
        if ($proveedor!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->proveedor, '1' )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($codInt!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->codigo, $codInt )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($codReu!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->codigoreu, $codReu )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($nombre!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->nombre, $nombre )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($siglas!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->abreviatura, $siglas )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
        //dd($organismo_id);
        if ($organismo_id!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->idOrganismo, $organismo_id )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($grupo!= null || $grupo != "1") {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->idGrupo, $grupo )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
        //dd($cliente_proveedor);

        return view('cliente_proveedor.index', compact('cliente_proveedor', 'CP','GO','organismos','grupos'));
    }

    public function organismoSearch(Request $request){
        $cod = $request->input('codigo');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $activo = $request->input('activo');


        $BaseQuery = Organismo::query()
        ->get();

        $organismo = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $organismo->push($BaseQuery[$i]);
        }

        if ($cod != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->codigoO, $cod )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($siglas != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->siglasO, $siglas )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($nombre != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->nombreO, $nombre )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($activo != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if($organismo[$i]->activoO == $activo){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }
        //dd($activo);
        //$organismo = Organismo::all();
        return view('organismo.index',compact('organismo'));
    }

    public function grupoSearch(Request $request){
        $cod = $request->input('codigo');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $organismo_id = $request->input('organismo');
        if($organismo_id == "1"){
            $organismo_id = null;
        }
        $organismo = Organismo::all();

        $BaseQuery = Grupo::query()
        ->get();

        $grupo = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $grupo->push($BaseQuery[$i]);
        }

        if ($cod != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->codigoG, $cod )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($siglas != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->siglasG, $siglas )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($nombre != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->nombreG, $nombre )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($organismo != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->id_Organismo, $organismo_id )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }
        //dd($activo);
        //$organismo = Organismo::all();
        //$grupo = Grupo::all();
        return view('grupo.index',compact('grupo','organismo'));
    }
}
