<?php

namespace App\Http\Controllers;

use App\Models\EntidadGO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DropdownController extends Controller
{
 public function index()
 {
 $countries = DB::table("organismos")->pluck("nombre","id");
 return view('welcome',compact('countries'));
 }

 public function getGrupo(Request $request)
 {
 $grupos = DB::table("grupos")
 ->where("id_Organismo",$request->organismo_id)
 ->pluck("nombreG","id");
 return response()->json($grupos);
 }

 public function getGrupoEntidad(Request $request)
 {
 $grupos = EntidadGO::where("idOrganismo",$request->organismo_id)
 ->join("dbo.grupos", 'dbo.grupos.id', '=', 'idGrupo')
 ->pluck("nombreG","idGrupo");
 return response()->json($grupos);
 }

 public function getClient(Request $request)
 {
    $clients = EntidadGO::where("idGrupo",$request->grupo_id)
    ->join("dbo.ClientsView", 'dbo.ClientsView.identidad', '=', 'idClientGO')
    ->pluck("dbo.ClientsView.nombre","idClientGO");
    return response()->json($clients);
 }

 public function getClientEntidad(Request $request)
 {
    $clients = EntidadGO::where("idGrupo",$request->grupoID)
    ->where("idOrganismo", $request->organismoID)
    ->join("dbo.ClientsView", 'dbo.ClientsView.identidad', '=', 'idClientGO')
    ->pluck("dbo.ClientsView.nombre","idClientGO");
    return response()->json($clients);
 }
}
