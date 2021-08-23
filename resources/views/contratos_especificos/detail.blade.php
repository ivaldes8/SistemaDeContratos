@extends('layouts.frontend')

@section('content')

<div class="mt-3" style="margin-left: 2%; margin-right: 2%">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8" style="font-size: 80%">
                            <p style="margin-bottom: 0px">Contrato No: {{$CM->noContrato}}</p>
                            <p style="margin-bottom: 0px">Objeto del Contrato: {{$CM->objeto}}</p>
                            <p style="margin-bottom: 0px">Organismo: {{$CM->organismos->nombreO}}</p>
                            <p>Cliente: {{$CM->cliente->nombre}}</p>  
                        </div>
                        <div class="col-4">
                            <a href="{{url('contratos_especificos/create/' .$CM->id)}}" class="btn btn-primary mt-3">Crear Contrato Específico</a>
                        </div>
                        <hr/>
                    </div>
                    <form action="{{ url('CESearch') }}"  method="GET">
                        <div class="row">
                            <div class="col-5">
                                <div class="row mb-2">
                                    <div class="col-5">
                                        No. Contrato Específico:
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control form-control-sm" name="noCE"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        Cod. Interno:
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control form-control-sm" name="codInt"/>
                                    </div>
                                </div>
                                 <div class="row mb-2">
                                    <div class="col-3">
                                        Organismo:
                                    </div>
                                    <div class="col-9">
                                        <select id="organismo" name="organismo" class="col-8 form-control form-control-sm">
                                            @foreach ( $organismos as $item )
                                            <option value="{{$item->id}}">{{$item->nombreO}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="row mb-2">
                                    <div class="col-3">
                                        Grupo:
                                    </div>
                                    <div class="col-9">
                                        <select name="grupo" id="grupo" class="col-8 form-control form-control-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        Cliente:
                                    </div>
                                    <div class="col-9">
                                        <select name="cliente" id="client" class="col-8 form-control form-control-sm">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        Cod. Servicio:
                                    </div>
                                    <div class="col-7">
                                        <input type='text' class="form-control form-control-sm"  name="codServicio" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row mb-2">
                                    <div class="col-3">
                                        No. Contrato:
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control form-control-sm" name="noCM"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        Cod. REEUP:
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control form-control-sm" name="codReu"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                       Área:
                                    </div>
                                    <div class="col-9">
                                        <select name="area" class="col-8 form-control form-control-sm">
                                            <option value="@">Ningún área seleccionada</option>
                                             @foreach ( $area as $item )
                                            <option value="{{$item->idarea}}">{{$item->Expr4}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        Estado:
                                    </div>
                                    <div class="col-7">
                                        <select name="estado" class="col-8 form-control form-control-sm">
                                            <option value="@">Ningún estado seleccionado</option>
                                                <option>Sin Comenzar</option>
                                                <option>En Proceso</option>
                                                <option>Terminado</option>
                                                <option>Cancelado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        Fecha de firma Desde:
                                    </div>
                                    <div class="col-7">
                                        <input type='text' class="form-control form-control-sm" id="datepicker"  name="FfechaIni" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        Hasta:
                                    </div>
                                    <div class="col-6">
                                        <input type='text' class="form-control form-control-sm" id="datepicker2"  name="FfechaEnd" />
                                    </div>
                                    <div class="col-1">
                                        <input style="display: none" value="1" type='text' class="form-control form-control-sm"  name="url" />
                                    </div>
                                </div>
                                
                        </div>
                        <div class="col-2">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <button class="btn btn-primary" type="submit">Buscar</button>
                            <a class="btn btn-primary" id="button-a">Excel</a>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped" id="mytable">
                        <thead>
                            <tr style="font-size: 70%;">
                                <th style="width: 20px;">No.Contrato</th>
                                <th style="width: 40px;">No.Contrato Específico</th>
                                <th style="width: 120px;">Objeto del Contrato</th>
                                <th style="width: 120px;">Servicios</th>
                                <th style="width: 60px;">Área</th>
                                <th style="width: 60px;">Estado</th>
                                <th style="width: 120px;">Ejecutor</th>
                                <th style="width: 120px;">Cliente</th>
                                <th style="width: 60px;">Fecha de Firma</th>
                                <th style="width: 40px;">Fecha de Vencimiento</th>
                                <th style="width: 120px;">Observaciones</th>
                                <th style="width: 10px;">Monto</th>
                                <th style="width: 10px;">Suplementos</th>
                                <th style="width: 10px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($CE as $item)
                        <tr style="font-size: 70%; {{$item->estado == 'Terminado' ? 'background-color: red' : ''}}"
                            class = "{{ \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndCE)->format('d-m-y'))->gte($now) 
                                        &&
                                    \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndCE)->format('d-m-y'))->lte($ThreeDaysearly) 
                                        ? 'bg-warning' : ''}}">
                            <td>{{$item->CMs->noContrato}}</td>
                            <td><a href="{{url('contratos_especificos/'.$item->idCEspecifico.'/edit')}}">{{$item->noContratoEspecifico}}</a></td>
                            <td>{{$item->CMs->objeto}}</td>
                            <td>
                                @foreach ($servicios as $servicio)
                                    @if ($servicio->idContratoEspecifico == $item->idCEspecifico)
                                        /{{$servicio->servicios->Expr3}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$item->areas->Expr4}}</td>
                            <td>{{$item->estado}}</td>
                            <td>{{$item->ejecutorName}}</td>
                            <td>{{$item->clienteName}}</td>
                            <td>{{$item->fechaIniCE}}</td>
                            <td>{{$item->fechaEndCE}}</td>
                            <td>{{$item->observaciones}}</td>
                            <td>{{$item->monto}}</td>
                            <td><a href="{{url('suplementoce/'.$item->idCEspecifico)}}">Sup</a></td>
                            <td>
                                <form action="{{url('contratos_especificos/'.$item->idCEspecifico)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
