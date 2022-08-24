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
                        Editar Entidad
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('entidad/' . $entidad->identidad) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Código REU:</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ $entidad->codigoreu ? $entidad->codigoreu : '---' }}" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Código NIT:</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ $entidad->NIT ? $entidad->NIT : '---' }}" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" class="form-control form-control-sm" value="{{ $entidad->nombre }}" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Siglas:</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ $entidad->abreviatura ? $entidad->abreviatura : '---' }}" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Dirección:</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ $entidad->direccion ? $entidad->direccion : '' }}" disabled>
                    </div>


                    <div class="input-group">
                        <label class="mx-2" for="">Organismo:</label>
                        <select name="org_id" class="form-control orgSelect" id="organismo">
                            <option></option>
                            @foreach ($organismos as $item)
                                <option
                                    {{ $entidad->GrupoOrgnanismo && $entidad->GrupoOrgnanismo->organismo && $item->id === $entidad->GrupoOrgnanismo->organismo->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('org_id'))
                            <span class="text-danger">{{ $errors->first('org_id') }}</span>
                        @endif
                    </div>

                    <div class="input-group my-3">
                        <label class="mx-2" for="">Grupo:</label>
                        <select name="grupo_id" class="form-control grupoSelect" id="grupo">
                            <option></option>
                            @foreach ($grupos as $item)
                                <option
                                    {{ $entidad->GrupoOrgnanismo && $entidad->GrupoOrgnanismo->grupo && $item->id === $entidad->GrupoOrgnanismo->grupo->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('grupo_id'))
                            <span class="text-danger">{{ $errors->first('grupo_id') }}</span>
                        @endif
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cliente"
                            {{ $entidad->ClienteProveedor && $entidad->ClienteProveedor->isClient ? 'checked' : '' }}>
                        <label class="form-check-label" for="disabledFieldsetCheck">
                            Cliente
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="proveedor"
                            {{ $entidad->ClienteProveedor && $entidad->ClienteProveedor->isProvider ? 'checked' : '' }}>
                        <label class="form-check-label" for="disabledFieldsetCheck">
                            Proveedor
                        </label>
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.grupoSelect').select2({
                placeholder: "Grupo",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.orgSelect').select2({
                placeholder: "Organismo",
                allowClear: true
            });
        });
        $('#organismo').change(function() {
            var organismoID = $(this).val();
            if (organismoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('GrupoByOrganismo') }}?org_id=" + organismoID,
                    success: function(res) {
                        if (res) {
                            $("#grupo").empty();
                            $("#grupo").append('<option>Grupo no seleccionado</option>');
                            $.each(res, function(key, value) {
                                $("#grupo").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#grupo").empty();
                        }
                    }
                });
            } else {
                $("#grupo").empty();
            }
        });
    </script>
@endsection
