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
                      {{$objeto === "none" ? 'Crear objeto de suplemento' : 'Editar objeto de suplemento'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('objsupce')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($objeto === "none")
                <form action="{{url('objsupce')}}" method="POST">
            @else
                <form action="{{url('objsupce/'.$objeto->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf

                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $objeto !== 'none' ? $objeto->nombre : '' }}">
                        @if ($errors->has('nombre'))
                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Activo:</label>
                        <div class="form-check form-switch">
                            <input name="activo" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $objeto !== 'none' && $objeto->activo == 1 ? 'checked' : $objeto === 'none' ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$objeto === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

