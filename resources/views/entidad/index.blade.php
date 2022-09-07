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
                    <div class="col-12 mt-1 d-flex justify-content-start">
                        Entidades
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (request()->is('proveedor'))
                    <form action="{{ url('proveedor') }}" method="get">
                @endif
                @if (request()->is('cliente'))
                    <form action="{{ url('cliente') }}" method="get">
                @endif
                @if (request()->is('entidad'))
                    <form action="{{ url('entidad') }}" method="get">
                @endif

                <div class="row">
                    <div class="col-2 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="codigoreu" class="form-control form-control-sm" placeholder="Código REU" />
                        </div>
                    </div>

                    <div class="col-1 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="codigo" class="form-control form-control-sm" placeholder="Código Interno" />
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="nombre" class="form-control form-control-sm" placeholder="Nombre" />
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="abreviatura" class="form-control form-control-sm" placeholder="Siglas" />
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="direccion" class="form-control form-control-sm" placeholder="Dirección" />
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="telefono" class="form-control form-control-sm" placeholder="Teléfono" />
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        <div class="input-group ">
                            <input name="NIT" class="form-control form-control-sm" placeholder="NIT" />
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo">
                            <label class="form-check-label">
                                Activo
                            </label>
                        </div>
                    </div>

                    <div class="col-3 mt-1 d-flex justify-content-start">
                        @if (request()->is('entidad'))
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cliente">
                                <label class="form-check-label">
                                    Cliente
                                </label>
                            </div>
                        @endif

                        @if (request()->is('entidad'))
                            <div class="mx-2 form-check">
                                <input class="form-check-input" type="checkbox" name="proveedor">
                                <label class="form-check-label">
                                    Proveedor
                                </label>
                            </div>
                        @endif

                    </div>

                    <div class="col-6 d-flex justify-content-end">
                        @if (request()->is('entidad'))
                            <a href="{{ url('entidad') }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-arrow-repeat"></i></a>
                        @endif
                        @if (request()->is('cliente'))
                            <a href="{{ url('cliente') }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-arrow-repeat"></i></a>
                        @endif
                        @if (request()->is('proveedor'))
                            <a href="{{ url('proveedor') }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-arrow-repeat"></i></a>
                        @endif

                        <button class="btn btn-sm btn-primary mx-1" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table table-primary table-sm table-bordered table-striped">
                    <thead>
                        <tr style="font-size: 90%;">
                            <th style="width: 100px;">Código Interno</th>
                            <th style="width: 340px;">Nombre</th>
                            <th style="width: 50px;">Código REU</th>
                            <th style="width: 150px;">Siglas</th>
                            <th style="width: 340px;">Dirección</th>
                            <th style="width: 200px;">Teléfono</th>
                            <th style="width: 100px;">NIT</th>
                            <th style="width: 280px;">Organismo</th>
                            <th style="width: 280px;">Grupo</th>
                            @if (request()->is('entidad'))
                                <th style="width: 50px;">Cliente</th>
                                <th style="width: 50px;">Proveedor</th>
                            @endif
                            <th style="width: 20px;">Activo</th>
                            @if (!request()->is('entidad'))
                                <th style="width: 20px;">Contratos</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($entidad) < 1)
                            <tr>
                                <td class="text-center" colspan="16">No se encontraron entidades</td>
                            </tr>
                        @else
                            @foreach ($entidad as $item)
                                <tr style="font-size: 80%;">
                                    <td>{{ $item->codigo ? $item->codigo : '---' }}</td>
                                    <td>
                                        <a style="font-weight: bold;"
                                            href="{{ url('entidad/' . $item->identidad . '/edit') }}"><i
                                                class="bi bi-pencil">{{ $item->nombre ? $item->nombre : '---' }}</i></a>
                                    </td>
                                    <td>{{ $item->codigoreu ? $item->codigoreu : '---' }}</td>
                                    <td style="font-size: 80%;">{{ $item->abreviatura ? $item->abreviatura : '---' }}</td>
                                    <td style="font-size: 70%;">{{ $item->direccion ? $item->direccion : '---' }}</td>
                                    <td>{{ $item->telefono ? $item->telefono : '---' }}</td>
                                    <td>{{ $item->NIT ? $item->NIT : '---' }}</td>
                                    <td>{{ $item->GrupoOrgnanismo && $item->GrupoOrgnanismo->organismo ? $item->GrupoOrgnanismo->organismo->nombre : '---' }}
                                    </td>
                                    <td>{{ $item->GrupoOrgnanismo && $item->GrupoOrgnanismo->grupo ? $item->GrupoOrgnanismo->grupo->nombre : '---' }}
                                    </td>
                                    @if (request()->is('entidad'))
                                        <td>
                                            <input style="width: 15px; height: 15px;" class="form-check-input"
                                                type="checkbox"
                                                {{ $item->ClienteProveedor && $item->ClienteProveedor->isClient ? 'checked' : '' }}
                                                disabled>
                                        </td>
                                        <td>
                                            <input style="width: 15px; height: 15px;" class="form-check-input"
                                                type="checkbox"
                                                {{ $item->ClienteProveedor && $item->ClienteProveedor->isProvider ? 'checked' : '' }}
                                                disabled>
                                        </td>
                                    @endif

                                    <td>
                                        <div class="form-check form-switch">
                                            <input style="width: 30px; height: 15px;" class="form-check-input"
                                                type="checkbox" role="switch" {{ $item->activo ? 'checked' : '' }}
                                                disabled>
                                        </div>
                                    </td>
                                    @if (request()->is('cliente'))
                                        <td>
                                            <a style="font-weight: bold;font-size: 180%"
                                                href="{{ url('cm/' . $item->identidad) }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                        </td>
                                    @endif
                                    @if (request()->is('proveedor'))
                                        <td>
                                            <a style="font-weight: bold;font-size: 180%"
                                                href="{{ url('cp/' . $item->identidad) }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex">
                    {{ $entidad->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Entidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.orgSelect').select2({
            placeholder: "Organismo",
            allowClear: true
        });
        $('.grupoSelect').select2({
            placeholder: "Grupo",
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
            }
        });
    </script>
@endsection
