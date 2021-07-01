<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        $title = "About Us Page";
        $body = "this is my about us page";
        return view('pages.about', compact('title', 'body'));
    }

    public function users($id)
    {
        $name = "Ivan Gonzalez - ". $id;
        $body = "this is my about us page";
        return view('pages.users', compact('name', 'body'));
    }
}
