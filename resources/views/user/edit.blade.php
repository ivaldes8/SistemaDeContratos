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
                    <h4>Editar Usuario
                    <a href="{{url('user')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{url('user/'.$user->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre de Usuario</label>
                            <input type="text" name="userName" class="form-control" value="{{ $user->userName }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Correo</label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Rol</label>
                            <input type="checkbox" name="role_as"  {!! $user->role_as == 1 ? 'checked' : '' !!}>0-user, 1-admin
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
