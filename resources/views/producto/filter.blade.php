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
                      Filtrar Productos
                    </div>
                </div>
            </div>
            <form action="{{ url('filteringProd') }}" method="get">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-bag-check" id="basic-addon1"></span>
                                <input type="text" name="descP" class="form-control" id="descProd" placeholder="Descripción del producto" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-journal-text" id="basic-addon1"></span>
                                <input id="cpcu" name="cpcu" type="text" class="form-control" placeholder="Código CPCU" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-journal-text" id="basic-addon1"></span>
                                <input id="saclap" name="saclap" type="text" class="form-control" placeholder="Código SACLAP" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="btn bi-journal-text" id="basic-addon1"></span>
                                <input id="cnae" name="cnae" type="text" class="form-control" placeholder="Código CNAE" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6 col-12 ">
                            <div class="form-group mb-3">
                                <span class="btn-sm bi-shop"  for="">Entidades:</span>
                                <select name="entidades[]" id="entidad" multiple="multiple" class="form-select entSelect">
                                    @foreach ($entidad as $item)
                                        <option  value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 ">
                            <div class="form-group mb-3">
                                <span class="btn-sm bi-building"  for="">Actividades Industriales:</span>
                                <select name="actividades[]" id="actividad" multiple="multiple" class="form-select entSelect">
                                    @foreach ($actividad as $item)
                                        <option  value="{{$item->id}}">{{$item->desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center">
                        <button id="clearFilters" class="btn btn-primary mx-1">Reiniciar Filtros</button>
                        <button class="btn btn-primary mx-1" type="submit">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Entidades</th>
                                <th>CPCU</th>
                                <th>SACLAP</th>
                                <th>CNAE</th>
                                <th>Actividad Industrial</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($producto) < 1)
                            <tr>
                                <td class="text-center" colspan="7">No se encontraron productos</td>
                            </tr>
                        @else
                            @foreach ($producto as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->desc}}</td>
                                    <td>@if (count($item->entidades) > 0)
                                            @foreach ($item->entidades as $entidad)
                                               / {{$entidad->name}}
                                            @endforeach
                                        @else
                                           ---
                                        @endif
                                    </td>
                                    <td>{{$item->cpcu ? $item->cpcu->codigo : '---'}}</td>
                                    <td>{{$item->saclap ? $item->saclap->codigo : '---'}}</td>
                                    <td>{{$item->cnae ? $item->cnae->codigo : '---'}}</td>
                                    <td>@if (count($item->actividades) > 0)
                                            @foreach ($item->actividades as $actividad)
                                               / {{$actividad->desc}}
                                            @endforeach
                                        @else
                                           ---
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $producto->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.actSelect').select2();
        });
        $(document).ready(function() {
            $('.entSelect').select2();
        });
        $(document).on('click', '#clearFilters', function(event) {
            event.preventDefault();
            $('.entSelect').val(null).trigger('change');
            $('.actSelect').val(null).trigger('change');
            var descProd = document.getElementById('descProd').value=""
            var cpcu = document.getElementById('cpcu').value=""
            var saclap = document.getElementById('saclap').value=""
            var cnae = document.getElementById('cnae').value=""
        });
    </script>
@endsection
