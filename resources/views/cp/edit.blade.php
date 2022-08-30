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
                        {{ $cp === 'none' ? 'Crear Contrato Marco' : 'Editar Contrato Marco' }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($cp === 'none')
                    <form action="{{ url('cp') }}" method="POST">
                    @else
                        <form action="{{ url('cp/' . $cp->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                @endif
                @csrf
                <div class="form-group mb-3">
                    <label for="">No. Contrato:</label>
                    <input type="text" name="noContrato" class="form-control"
                        value="{{ $cp !== 'none' ? $cp->noContrato : '' }}">
                    @if ($errors->has('noContrato'))
                        <span class="text-danger">{{ $errors->first('noContrato') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label class="mx-2" for="">Tipo:</label>
                    <select name="tipo_id" class="form-control tipoSelect">
                        <option></option>
                        @foreach ($tipos as $item)
                            <option {{ $cp !== 'none' && $item->id == $cp->tipo_id ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('tipo_id'))
                        <span class="text-danger">{{ $errors->first('tipo_id') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="mx-2" for="">Organismo:</label>
                    <select name="org_id" class="form-control orgSelect" id="organismo">
                        <option></option>
                        @foreach ($organismos as $item)
                            <option
                                {{ $cp !== 'none' && $cp->proveedor && $cp->proveedor->entidad && $cp->proveedor->entidad->GrupoOrgnanismo && $cp->proveedor->entidad->GrupoOrgnanismo->organismo && $item->id === $cp->proveedor->entidad->GrupoOrgnanismo->organismo->id ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('org_id'))
                        <span class="text-danger">{{ $errors->first('org_id') }}</span>
                    @endif
                </div>

                <div class="form-group my-3">
                    <label class="mx-2" for="">Grupo:</label>
                    <select name="grupo_id" class="form-control grupoSelect" id="grupo">
                        <option></option>
                        @foreach ($grupos as $item)
                            <option
                                {{ $cp !== 'none' && $cp->proveedor && $cp->proveedor->entidad && $cp->proveedor->entidad->GrupoOrgnanismo && $cp->proveedor->entidad->GrupoOrgnanismo->grupo && $item->id === $cp->proveedor->entidad->GrupoOrgnanismo->grupo->id ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('grupo_id'))
                        <span class="text-danger">{{ $errors->first('grupo_id') }}</span>
                    @endif
                </div>

                <div class="form-group my-3">
                    <label class="mx-2" for="">Proveedor:</label>
                    <select name="proveedor_id" class="form-control proveedorSelect" id="proveedor">
                        <option></option>
                        @foreach ($proveedores as $item)
                            <option
                                {{ $cp !== 'none' && $cp->proveedor && $item->identidad === $cp->proveedor->entidad_id ? 'selected' : '' }}
                                value="{{ $item->identidad }}">{{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('proveedor_id'))
                        <span class="text-danger">{{ $errors->first('proveedor_id') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label class="mx-2" for="">Estado:</label>
                    <select name="estado_id" class="form-control estadoSelect">
                        <option></option>
                        @foreach ($estados as $item)
                            <option {{ $cp !== 'none' && $item->id == $cp->estado_id ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('estado_id'))
                        <span class="text-danger">{{ $errors->first('estado_id') }}</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="">Fecha de firma:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaFirma" class="form-control date"
                                value="{{ $cp !== 'none' ? $cp->fechaFirma : '' }}" id="picker1">
                            @if ($errors->has('fechaFirma'))
                                <span class="text-danger">{{ $errors->first('fechaFirma') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="">Fecha de vencimiento:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaVenc" class="form-control date"
                                value="{{ $cp !== 'none' ? $cp->fechaVenc : '' }}" id="picker2">
                            @if ($errors->has('fechaVenc'))
                                <span class="text-danger">{{ $errors->first('fechaVenc') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="">Nombre del contacto:</label>
                    <input type="text" name="contacto" class="form-control"
                        value="{{ $cp !== 'none' ? $cp->contacto : '' }}">
                    @if ($errors->has('contacto'))
                        <span class="text-danger">{{ $errors->first('contacto') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Email del contacto:</label>
                    <input type="text" name="email" class="form-control"
                        value="{{ $cp !== 'none' ? $cp->email : '' }}">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Elaborado por:</label>
                    <input type="text" name="recibidoPor" class="form-control"
                        value="{{ $cp !== 'none' ? $cp->recibidoPor : '' }}">
                    @if ($errors->has('recibidoPor'))
                        <span class="text-danger">{{ $errors->first('recibidoPor') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Monto:</label>
                    <input type="number"  step="0.001" class="form-control"  value="{{ $cp !== 'none' ? $cp->monto : '' }}" name="monto">
                    @if ($errors->has('monto'))
                        <span class="text-danger">{{ $errors->first('monto') }}</span>
                    @endif
                </div>



                <div class="form-group mb-3">
                    <label for="">Observaciones:</label>
                    <textarea class="form-control" name="observ">
                        {{ $cp !== 'none' ? $cp->observ : '' }}
                    </textarea>
                    @if ($errors->has('observ'))
                        <span class="text-danger">{{ $errors->first('observ') }}</span>
                    @endif
                </div>

                @if ($cp !== 'none')
                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Adjunto1:</label>
                        <input class="form-control form-control-sm" name="file1" type="file" accept=".pdf">
                    </div>

                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Adjunto2:</label>
                        <input class="form-control form-control-sm" name="file2" type="file" accept=".pdf">
                    </div>

                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Adjunto3:</label>
                        <input class="form-control form-control-sm" name="file3" type="file" accept=".pdf">
                    </div>

                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Adjunto4:</label>
                        <input class="form-control form-control-sm" name="file4" type="file" accept=".pdf">
                    </div>
                @endif

                <div class="form-group my-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">{{ $cp === 'none' ? 'Crear' : 'Editar' }}</button>
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
        $(document).ready(function() {
            $('.proveedorSelect').select2({
                placeholder: "Proveedor",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.tipoSelect').select2({
                placeholder: "Tipo",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.estadoSelect').select2({
                placeholder: "Estado",
                allowClear: true
            });
        });
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            orientation: 'bottom'
        });
        $('#picker1').change(function() {
            let aux = $(this).val().split('-')
            let aux2 = Number(aux[0]) + 5
            $('#picker2').datepicker('setDate', aux2 + '-' + aux[0] + '-' + aux[1]);
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
                            $("#grupo").append("<option value='@'>Grupo no seleccionado</option>");
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
                $("#proveedor").empty();
            }
        });
        $('#grupo').on('change', function() {
            var grupoID = $(this).val();
            if (grupoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ProveedorByGrupo') }}?grupo_id=" + grupoID,
                    success: function(res) {
                        if (res) {
                            $("#proveedor").empty();
                            $("#proveedor").append(
                                "<option value='@'>Proveedor no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#proveedor").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#proveedor").empty();
                        }
                    }
                });
            } else {
                $("#proveedor").empty();
            }
        });
    </script>
@endsection
