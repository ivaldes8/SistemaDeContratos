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
                      {{$estado === "none" ? 'Crear estado' : 'Editar estado'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('estadoce')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($estado === "none")
                <form action="{{url('estadoce')}}" method="POST">
            @else
                <form action="{{url('estadoce/'.$estado->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf

                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $estado !== 'none' ? $estado->nombre : '' }}">
                        @if ($errors->has('nombre'))
                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Activo:</label>
                        <div class="form-check form-switch">
                            <input name="activo" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $estado !== 'none' && $estado->activo == 1 ? 'checked' : $estado === 'none' ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$estado === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

