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
                    <div class="col-9 mt-1 d-flex justify-content-start">
                        Áreas/Servicios
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('areaserv') }}" method="get">
                    <div class="row">
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input name="servCod" type="text" class="form-control form-control-sm"
                                    placeholder="Cod. Servicio" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-5 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="serv_id" class="form-control form-control-sm servSelect">
                                    <option></option>
                                    @foreach ($servicioSelect as $item)
                                        <option value="{{ $item->idservicio }}">{{ $item->codigo }}/{{ $item->Descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="area_id" class="form-control form-control-sm areaSelect">
                                    <option></option>
                                    @foreach ($areasSelect as $item)
                                        <option value="{{ $item->idarea }}">{{ $item->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a href="{{ url('areaserv') }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-arrow-repeat"></i></a>
                            <button class="btn btn-sm btn-primary mx-1" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Código</th>
                                <th style="width: 340px;">Servicio</th>
                                <th>Área</th>
                                <th style="width: 100px;">Activa</th>
                                <th style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($servicios) < 1)
                                <tr>
                                    <td class="text-center" colspan="7">No se encontraron servicios</td>
                                </tr>
                            @else
                                @foreach ($servicios as $item)
                                    <tr>
                                        <td>{{ $item->codigo ? $item->codigo : '---' }}</td>
                                        <td>{{ $item->Descripcion ? $item->Descripcion : '---' }}</td>
                                        <td>
                                            {{ $item->AreaServicio && $item->AreaServicio->area ? $item->AreaServicio->area->descripcion : '---' }}
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked"
                                                    {{ $item->AreaServicio && $item->AreaServicio->area && $item->AreaServicio->area->activa ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('areaserv/' . $item->idservicio . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $servicios->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.areaSelect').select2({
                placeholder: "Áreas",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.servSelect').select2({
                placeholder: "Servicios",
                allowClear: true
            });
        });
    </script>
@endsection
