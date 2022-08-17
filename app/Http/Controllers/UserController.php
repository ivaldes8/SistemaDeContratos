<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10);
        return view('user.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = 'none';
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
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
            'name' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email',
            'role' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'password.required' => 'Este campo es requerido',
            'password.min' => 'La contraseña debe tener más de 5 caracteres',
            'role.require' => 'Este campo es requerido',
            'email.required' => 'Este campo es requerido',
            'email.email' => 'Tiene que introducir un correo valido',
            'email.unique' => 'Este correo ya existe en la base de datos'
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->active = $request->input('active') === 'on' ? 1 : 0;
        $user->save($validatedData);
        return redirect('/user')->with('status','Usuario creado satisfactoriamente');
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
        $user = User::find($id);
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
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
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ], [
            'name.required' => 'Este campo es requerido',
            'role.require' => 'Este campo es requerido',
            'email.required' => 'Este campo es requerido',
            'email.email' => 'Tiene que introducir un correo valido'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->active = $request->input('active') === 'on' ? 1 : 0;
        $user->update($validatedData);
        return redirect('/user')->with('status','Usuario Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $user = User::find($id);
        return view('user.delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('status','Usuario eliminado Satisfactoriamente');
    }
}

