@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
            @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                        {{$user === "none" ? 'Crear usuario' : 'Editar usuario'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('user')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($user === "none")
                <form action="{{url('user')}}" method="POST">
            @else
                <form action="{{url('user/'.$user->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" name="name" class="form-control" value="{{ $user !== 'none' ? $user->name : '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Correo:</label>
                        <input type="text" name="email" class="form-control" value="{{ $user !== 'none' ? $user->email : '' }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    @if ($user === 'none')
                    <div class="form-group mb-3">
                        <label for="">Contraseña:</label>
                        <input type="password" name="password" class="form-control">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="">Rol:</label>
                        <select name="role" class="form-select roleSelect">
                            @foreach ($roles as $role)
                                <option value="{{$role->name}}" {{ $user !== 'none' && $user->role === $role->name ? 'selected' : '' }}>{{$role->name}}</option>
                            @endforeach

                        </select>
                        @if ($errors->has('role'))
                            <span class="text-danger">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Activo:</label>
                        <div class="form-check form-switch">
                            <input name="active" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $user !== 'none' && $user->active === 1 ? 'checked' : $user === 'none' ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$user === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.roleSelect').select2();
        });
    </script>
@endsection

