@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                        {{ $grupo === 'none' ? 'Crear Grupo' : 'Editar Grupo' }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('grupo') }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($grupo === 'none')
                    <form action="{{ url('grupo') }}" method="POST">
                    @else
                        <form action="{{ url('grupo/' . $grupo->id) }}" method="POST">
                            @method('PUT')
                @endif
                @csrf
                <div class="form-group mb-3">
                    <label for="">Código:</label>
                    <input type="text" name="codigo" class="form-control"
                        value="{{ $grupo !== 'none' ? $grupo->codigo : '' }}">
                    @if ($errors->has('codigo'))
                        <span class="text-danger">{{ $errors->first('codigo') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Nombre:</label>
                    <input type="text" name="nombre" class="form-control"
                        value="{{ $grupo !== 'none' ? $grupo->nombre : '' }}">
                    @if ($errors->has('nombre'))
                        <span class="text-danger">{{ $errors->first('nombre') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Siglas:</label>
                    <input type="text" name="siglas" class="form-control"
                        value="{{ $grupo !== 'none' ? $grupo->siglas : '' }}">
                    @if ($errors->has('siglas'))
                        <span class="text-danger">{{ $errors->first('siglas') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Organismo:</label>
                    <select name="org_id" class="form-select orgSelect">
                        <option></option>
                        @foreach ($organismos as $item)
                            <option {{ $grupo !== 'none' && $item->id == $grupo->org_id ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->siglas }}/ {{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('org_id'))
                        <span class="text-danger">{{ $errors->first('org_id') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Activo:</label>
                    <div class="form-check form-switch">
                        <input name="activo" class="form-check-input" type="checkbox" role="switch"
                            id="flexSwitchCheckChecked"
                            {{ ($grupo !== 'none' && $grupo->activo == 1 ? 'checked' : $grupo === 'none') ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="form-group mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">{{ $grupo === 'none' ? 'Crear' : 'Editar' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.orgSelect').select2({
                placeholder: "Organismo",
            });
        });
    </script>
@endsection
