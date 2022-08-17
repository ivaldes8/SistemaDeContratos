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
                      {{$entidad === "none" ? 'Crear Entidad' : 'Editar Entidad'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('entidad')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($entidad === "none")
                <form action="{{url('entidad')}}" method="POST">
            @else
                <form action="{{url('entidad/'.$entidad->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Código REU:</label>
                        <input type="text" name="codREU" class="form-control" value="{{ $entidad !== 'none' ? $entidad->codREU : '' }}">
                        @if ($errors->has('codREU'))
                            <span class="text-danger">{{ $errors->first('codREU') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Código NIT:</label>
                        <input type="text" name="codNIT" class="form-control" value="{{ $entidad !== 'none' ? $entidad->codNIT : '' }}">
                        @if ($errors->has('codNIT'))
                            <span class="text-danger">{{ $errors->first('codNIT') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" name="name" class="form-control" value="{{ $entidad !== 'none' ? $entidad->name : '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Siglas:</label>
                        <input type="text" name="siglas" class="form-control" value="{{ $entidad !== 'none' ? $entidad->siglas : '' }}">
                        @if ($errors->has('siglas'))
                            <span class="text-danger">{{ $errors->first('siglas') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Direccion:</label>
                        <input type="text" name="direccion" class="form-control" value="{{ $entidad !== 'none' ? $entidad->direccion : '' }}">
                        @if ($errors->has('direccion'))
                            <span class="text-danger">{{ $errors->first('direccion') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">DPA:</label>
                        <input type="text" name="dpa" class="form-control" value="{{ $entidad !== 'none' ? $entidad->dpa : '' }}">
                        @if ($errors->has('dpa'))
                            <span class="text-danger">{{ $errors->first('dpa') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Código de Forma Organizativa:</label>
                        <input type="text" name="codFormOrg" class="form-control" value="{{ $entidad !== 'none' ? $entidad->codFormOrg : '' }}">
                        @if ($errors->has('codFormOrg'))
                            <span class="text-danger">{{ $errors->first('codFormOrg') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Forma Organizativa:</label>
                        <input type="text" name="formOrg" class="form-control" value="{{ $entidad !== 'none' ? $entidad->formOrg : '' }}">
                        @if ($errors->has('formOrg'))
                            <span class="text-danger">{{ $errors->first('formOrg') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">OSDE:</label>
                        <select name="osde_id" class="form-select osdeSelect">
                            @foreach ($osde as $osd)
                                <option {{ $entidad !== 'none' && $osd->id == $entidad->osde_id ? 'selected' : '' }} value="{{$osd->id}}">{{$osd->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('osde_id'))
                            <span class="text-danger">{{ $errors->first('osde_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Organismo:</label>
                        <select name="org_id" class="form-select organismoSelect">
                            @foreach ($organismo as $org)
                                <option {{ $entidad !== 'none' && $org->id == $entidad->org_id ? 'selected' : '' }} value="{{$org->id}}">{{$org->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('org_id'))
                            <span class="text-danger">{{ $errors->first('org_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$entidad === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.osdeSelect').select2();
        });
        $(document).ready(function() {
            $('.organismoSelect').select2();
        });
    </script>
@endsection

