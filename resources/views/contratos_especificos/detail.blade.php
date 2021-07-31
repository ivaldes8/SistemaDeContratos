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
                        <div class="col-11" style="font-size: 80%">
                            <p style="margin-bottom: 0px">Contrato No: {{$CM->noContrato}}</p>
                            <p style="margin-bottom: 0px">Objeto del Contrato: {{$CM->objeto}}</p>
                            <p style="margin-bottom: 0px">Organismo: {{$CM->organismos->nombreO}}</p>
                            <p>Cliente: {{$CM->cliente->nombre}}</p>
                            
                        </div>
                        <div class="col-1">
                            <a href="{{url('contratos_especificos/create/' .$CM->id)}}" class="btn btn-primary mt-3"><svg  style="width: 30%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/></svg></a>
                        </div>
                        <hr/>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            Filtros<svg xmlns="http://www.w3.org/2000/svg" style="width: 2%;" viewBox="0 0 512 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped">
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
                            <tr style="font-size: 70%; {{$item->fechaEnd <= $now ? 'background-color: red' : ''}}"
                            class = "{{$item->fechaEnd <= $ThreeDaysearly && $item->fechaEnd > $now ? 'bg-warning' : ''}}">
                            <td>{{$item->CMs->noContrato}}</td>
                            <td><a href="{{url('contratos_especificos/'.$item->id.'/edit')}}">{{$item->noContratoEspecifico}}</a></td>
                            <td>{{$item->CMs->objeto}}</td>
                            <td>
                                @foreach ($servicios as $servicio)
                                    @if ($servicio->idContratoEspecifico == $item->id)
                                        /{{$servicio->servicios->Expr3}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$item->areas->Expr4}}</td>
                            <td>{{$item->estado}}</td>
                            <td>{{$item->ejecutorName}}</td>
                            <td>{{$item->clienteName}}</td>
                            <td>{{$item->fechaIni}}</td>
                            <td>{{$item->fechaEnd}}</td>
                            <td>{{$item->observaciones}}</td>
                            <td>{{$item->monto}}</td>
                            <td>Suplementos</td>
                            <td>
                                <form action="{{url('contratos_especificos/'.$item->id)}}" method="POST">
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
