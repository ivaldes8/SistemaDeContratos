<?php

namespace App\Http\Controllers;

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
 ->pluck("nombre","id");
 return response()->json($grupos);
 }
}
