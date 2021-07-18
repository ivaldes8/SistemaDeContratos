@extends('layouts.frontend')

@section('content')

<div class="mt-3 ml-3 mr-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            Filtros<svg xmlns="http://www.w3.org/2000/svg" style="width: 2%;" viewBox="0 0 512 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg>
                        </div>
                        <div class="col-2">
                            <a href="{{url('contratos_marco/create')}}" class="btn btn-primary"><svg  style="width: 10%;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/></svg></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr style="font-size: 70%;">
                                <th style="width: 20px;">No.Contrato</th>
                                <th style="width: 20px;">Código Interno</th>
                                <th style="width: 40px;">Código REEUP</th>
                                <th style="width: 120px;">Cliente</th>
                                <th style="width: 80px;">Siglas</th>
                                <th style="width: 80px;">OACES</th>
                                <th style="width: 120px;">Objeto del Contrato</th>
                                <th style="width: 20px;">Estado</th>
                                <th style="width: 80px;">Fecha de Firma</th>
                                <th style="width: 80px;">Fecha de Vencimiento</th>
                                <th style="width: 120px;">Observaciones</th>
                                <th style="width: 10px;">Contrato</th>
                                <th style="width: 10px;">Contratos Específicos</th>
                                <th style="width: 10px;">Suplementos</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($CM as $item)
                            <tr style="font-size: 70%; {{$item->fechaEnd <= $now ? 'background-color: red' : ''}}"
                            class = "{{$item->fechaEnd <= $ThreeDaysearly && $item->fechaEnd > $now ? 'bg-warning' : ''}}">
                                <td><a href="{{url('contratos_marco/'.$item->id.'/edit')}}">{{$item->noContrato}}</a></td>
                                <td><a href="{{url('clientes_proveedores/'.$item->idClient.'/edit')}}">{{$item->cliente->codigo}}</a></td>
                                <td>{{$item->cliente->codigoreu}}</td>
                                <td>{{$item->cliente->nombre}}</td>
                                <td>{{$item->cliente->abreviatura}}</td>
                                <td>{{$item->organismos->siglas}}/{{$item->grupos->siglas}}</td>
                                <td>{{$item->objeto}}</td>
                                <td>{{$item->estado}}</td>
                                <td>{{$item->fechaIni}}</td>
                                <td>{{$item->fechaEnd}}</td>
                                <td>{{$item->observaciones}}</td>
                                <td><a href="http://127.0.0.1/Sistema%20de%20Contratos/storage/app/public/{{$item->idFile}}"><svg xmlns="http://www.w3.org/2000/svg" style="width: 15%;" viewBox="0 0 384 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"/></svg></a></td>
                                <td>LOL</td>
                                <td>LOL</td>
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
