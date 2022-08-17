<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function test(Request $request){
        return response()->json($request);
    }
}
