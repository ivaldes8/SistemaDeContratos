@extends('layouts.app')

@section('content')
    <div class="mx-5 mt-3">
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
                    <div class="row">
                        <div class="col-9 mt-1 d-flex justify-content-start">
                            Contratos
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <a href="{{ url('cp/create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('cp') }}" method="get">
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="noContrato" class="form-control form-control-sm" placeholder="No. Contrato" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codigo" class="form-control form-control-sm" placeholder="Código interno" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codigoreu" class="form-control form-control-sm" placeholder="Código REU" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="tipo_id" class="form-control form-control-sm tipoSelect">
                                    <option></option>
                                    @foreach ($tipos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="estado_id" class="form-control form-control-sm estadoSelect">
                                    <option></option>
                                    @foreach ($estados as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="org_id" class="form-control form-control-sm orgSelect" id="organismo">
                                    <option></option>
                                    @foreach ($organismos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="grupo_id" class="form-control form-control-sm grupoSelect" id="grupo">
                                    <option></option>
                                    @foreach ($grupos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="proveedor_id" class="form-control form-control-sm clienteSelect"
                                    id="cliente">
                                    <option></option>
                                    @foreach ($proveedores as $item)
                                        <option value="{{ $item->identidad }}">
                                            {{ $item->nombre }}-{{ $item->abreviatura }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaIniFrom" class="form-control form-control-sm date"
                                    placeholder="Fecha de firma desde" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaIniTo" class="form-control form-control-sm date"
                                    placeholder="Fecha de firma hasta" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaEndFrom" class="form-control form-control-sm date"
                                    placeholder="Fecha de venc. desde" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaEndTo" class="form-control form-control-sm date"
                                    placeholder="Fecha de venc. hasta" />
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center my-2">
                            <button class="btn btn-sm btn-primary mx-1" disabled>
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>

                            <a href="{{ url('cp') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-repeat"></i>
                            </a>

                            <button class="btn btn-sm btn-primary mx-1" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table  table-sm table-bordered table-striped">
                    <thead>
                        <tr style="font-size: 80%;">
                            <th style="width: 100px;">No. Contrato</th>
                            <th style="width: 100px;">Código interno</th>
                            <th style="width: 100px;">Código REU</th>
                            <th style="width: 430px;">Cliente</th>
                            <th style="width: 200px;">Siglas</th>
                            <th style="width: 200px;">OACES</th>
                            <th style="width: 430px;">Objeto del contrato</th>
                            <th style="width: 150px;">Estado</th>
                            <th style="width: 450px;">Fecha de firma</th>
                            <th style="width: 150px;">Fecha de vencimiento</th>
                            <th style="width: 150px;">Monto</th>
                            <th style="width: 430px;">Observaciones</th>
                            <th style="width: 500px;">Contrato</th>
                            <th style="width: 100px;">Suplementos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($cp) < 1)
                            <tr>
                                <td class="text-center" colspan="16">No se encontraron Contratos marco</td>
                            </tr>
                        @else
                            @foreach ($cp as $item)
                                <tr class="{{ (\Carbon\Carbon::parse($item->fechaVenc)->addMonth(3)->lte($now)? 'bg-warning': \Carbon\Carbon::parse($item->fechaVenc)->lte($now))? 'bg-danger': '' }}"
                                    style="font-size: 70%">
                                    <td>
                                        <a style="font-weight: bold;" href="{{ url('cp/' . $item->id . '/edit') }}"><i
                                                class="bi bi-pencil">{{ $item->noContrato ? $item->noContrato : '---' }}</i></a>
                                    </td>
                                    <td>
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->codigo ? $item->proveedor->entidad->codigo : '---' }}
                                    </td>
                                    <td>
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->codigoreu ? $item->proveedor->entidad->codigoreu : '---' }}
                                    </td>
                                    <td style="font-size: 80%;">
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->nombre ? $item->proveedor->entidad->nombre : '---' }}
                                    </td>
                                    <td style="font-size: 80%;">
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->abreviatura ? $item->proveedor->entidad->abreviatura : '---' }}</td>
                                    <td>
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->GrupoOrgnanismo && $item->proveedor->entidad->GrupoOrgnanismo->organismo ? $item->proveedor->entidad->GrupoOrgnanismo->organismo->siglas : '---' }}/
                                        {{ $item->proveedor && $item->proveedor->entidad && $item->proveedor->entidad->GrupoOrgnanismo && $item->proveedor->entidad->GrupoOrgnanismo->grupo ? $item->proveedor->entidad->GrupoOrgnanismo->grupo->siglas : '---' }}
                                    </td>
                                    <td>{{ $item->tipo ? $item->tipo->nombre : '---' }}</td>
                                    <td>{{ $item->estado ? $item->estado->nombre : '---' }}</td>
                                    <td>{{ $item->fechaFirma ? $item->fechaFirma : '---' }}</td>
                                    <td>{{ $item->fechaVenc ? $item->fechaVenc : '---' }}</td>
                                    <td>{{ $item->monto ? $item->monto : '---' }}</td>
                                    <td>{{ $item->observ ? $item->observ : '---' }}</td>
                                    @if ($item->file)
                                        <td>
                                            @if ($item->file->file1)
                                                <a style="font-weight: bold;font-size: 180%"
                                                    href="{{ asset('storage/' . $item->file->path . '/' . $item->file->file1) }}"><i
                                                        class="bi bi-dice-1"></i></a>
                                            @else
                                                -
                                            @endif
                                            @if ($item->file->file2)
                                                <a style="font-weight: bold;font-size: 180%"
                                                    href="{{ asset('storage/' . $item->file->path . '/' . $item->file->file2) }}"><i
                                                        class="bi bi-dice-2"></i></a>
                                            @else
                                                -
                                            @endif
                                            @if ($item->file->file3)
                                                <a style="font-weight: bold;font-size: 180%"
                                                    href="{{ asset('storage/' . $item->file->path . '/' . $item->file->file3) }}"><i
                                                        class="bi bi-dice-3"></i></a>
                                            @else
                                                -
                                            @endif
                                            @if ($item->file->file4)
                                                <a style="font-weight: bold;font-size: 180%"
                                                    href="{{ asset('storage/' . $item->file->path . '/' . $item->file->file4) }}"><i
                                                        class="bi bi-dice-4"></i></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @else
                                        <td>---</td>
                                    @endif
                                    <td>
                                        <a style="font-weight: bold;font-size: 180%"
                                            href="{{ url('supcp/' . $item->id) }}">
                                            <i class="bi bi-file-earmark-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex">
                    {{ $cp->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            orientation: 'bottom'
        });
        $('.orgSelect').select2({
            placeholder: "Organismo",
            allowClear: true
        });
        $('.grupoSelect').select2({
            placeholder: "Grupo",
            allowClear: true
        });
        $('.clienteSelect').select2({
            placeholder: "Proveedor",
            allowClear: true
        });
        $('.tipoSelect').select2({
            placeholder: "Tipo de contrato",
            allowClear: true
        });
        $('.estadoSelect').select2({
            placeholder: "Estado",
            allowClear: true
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
                $("#cliente").empty();
            }
        });
        $('#organismo').change(function() {
            var organismoID = $(this).val();
            if (organismoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ProveedorByOrganismo') }}?org_id=" + organismoID,
                    success: function(res) {
                        if (res) {
                            $("#cliente").empty();
                            $("#cliente").append("<option value='@'>Proveedor no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#cliente").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#cliente").empty();
                        }
                    }
                });
            } else {
                $("#grupo").empty();
                $("#cliente").empty();
            }
        });
        $('#grupo').on('change', function() {
            var grupoID = $(this).val();
            if (grupoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ClienteByGrupo') }}?grupo_id=" + grupoID,
                    success: function(res) {
                        if (res) {
                            $("#cliente").empty();
                            $("#cliente").append("<option value='@'>Proveedor no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#cliente").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#cliente").empty();
                        }
                    }
                });
            } else {
                $("#cliente").empty();
            }
        });
    </script>
@endsection
