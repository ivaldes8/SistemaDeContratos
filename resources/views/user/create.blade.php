@extends('layouts.frontend')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    <h4>Crear Usuario
                    <a href="{{url('user')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{url('user')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre de Usuario</label>
                            <input type="text" name="userName" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Correo</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Contraseña</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Rol:</label>
                            <select name="role_as" class="col-8 form-control">
                                <option value="1">Administrador</option>
                                <option value="2">Facturador</option>
                                <option value="3">Usuario</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
