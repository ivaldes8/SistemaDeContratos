@extends('layouts.frontend')

@section('content')

<div class="mt-3">
    <div class="col-12 container">
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h1>Filtros</h1>
            <div class="fa fa-search"></div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-striped">
                <thead>
                    <tr style="font-size: 70%;">
                        <th style="width: 60px;">Cod.interno</th>
                        <th style="width: 60px;">Código REEUP</th>
                        <th style="width: 120px;">Nombre</th>
                        <th style="width: 120px;">Siglas</th>
                        <th style="width: 200px;">Organismo</th>
                        <th style="width: 120px;">Grupo</th>
                        <th style="width: 20px;">Cliente</th>
                        <th style="width: 20px;">Provedor</th>
                        <th style="width: 40px;">Contratos</th>
                        <th style="width: 40px;">Activo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cliente_proveedor as $item)
                    <tr style="font-size: 70%;">
                        <td><a href="{{url('clientes_proveedores/'.$item->identidad.'/edit')}}">{{$item->codigo}}</a></td>
                        <td>{{$item->codigoreu}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->abreviatura}}</td>
                        @foreach ($GO as $item3)
                            @if ($item3->idClient == $item->identidad)
                                <td>{{ $item3->organismos->nombre }}</td>
                                @break
                            @endif
                        @endforeach
                        @foreach ($GO as $item4)
                            @if ($item4->idClient == $item->identidad)
                                <td>{{ $item4->grupos->nombre }}</td>
                                @break
                            @endif
                        @endforeach
                        @foreach ($CP as $item2)
                            @if ($item2->idClient == $item->identidad)
                                <td>{{ $item2->cliente == true ? 'Si' : 'No' }}</td>
                                <td>{{ $item2->proveedor == true ? 'Si' : 'No' }}</td>
                                @break
                            @endif
                        @endforeach
                        <td>Contrato</td>
                        <td>
                            @if ($item->activo == 1)
                                Activo
                            @else
                                No Activo
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$cliente_proveedor->links()}}
        </div>
    </div>
    </div>
</div>
@endsection
