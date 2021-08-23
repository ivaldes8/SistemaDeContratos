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
                            <a href="{{url('suplementocm/create/' .$CM->id)}}" class="btn btn-primary mt-3">Crear Suplemento de Contrato Marco</a>
                        </div>
                        <hr/>
                    </div>
                    <form action="{{ url('sup_cm_search') }}"  method="GET">
                        <div class="row">
                            <div class="col-5">
                                <div class="row mb-3">
                                    <div class="col-5">
                                        No. Suplemento:
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control form-control-sm" name="noSup"/>
                                    </div>
                                </div>
                                 <div class="row mb-2">
                                    <div class="col-5">
                                        Fecha de inicio:
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
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row mt-5 mb-2">
                                    <div class="col-5">
                                        Fecha de cierre:
                                    </div>
                                    <div class="col-7">
                                        <input type='text' class="form-control form-control-sm" id="datepicker3"  name="VfechaIni" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5">
                                        Hasta:
                                    </div>
                                    <div class="col-6">
                                        <input type='text' class="form-control form-control-sm" id="datepicker4"  name="VfechaEnd" />
                                    </div>
                                </div>
                                
                        </div>
                        <div class="col-2">
                            <br>
                            <br>
                            <br>
                            <br>   
                            <button class="btn btn-primary" type="submit">Buscar</button>
                            <a class="btn btn-primary" id="button-a">Excel</a>
                        </div>
                    </form>
                </div>
            </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped" id="mytable">
                        <thead>
                            <tr style="font-size: 70%;">
                                <th style="width: 20px;">No.ContratoMarco</th>
                                <th style="width: 20px;">No.Suplemento</th>
                                <th style="width: 120px;">Objeto</th>
                                <th style="width: 120px;">Ejecutor</th>
                                <th style="width: 60px;">Fecha de Firma</th>
                                <th style="width: 60px;">Fecha de Cierre</th>
                                <th style="width: 120px;">Observaciones</th>
                                <th style="width: 20px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($Sup as $item)
                        <tr style="font-size: 70%; {{\Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->lte($now) ? 'background-color: red' : ''}}"
                            class = "{{ \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->gte($now) 
                                        &&
                                    \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->lte($ThreeDaysearly) 
                                        ? 'bg-warning' : ''}}">
                            <td>{{$item->CMs->noContrato}}</td>
                            <td><a href="{{url('suplementocm/'.$item->id.'/edit')}}">{{$item->noSupCM}}</a></td>
                            <td>
                                @foreach ($objetos as $objeto)
                                    @if ($objeto->idSupCM == $item->id)
                                        /{{$objeto->ObjCMSups->ObjetoSuplementoCM}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$item->ejecutorSup}}</td>
                            <td>{{$item->fechaIniSup}}</td>
                            <td>{{$item->fechaEndSup}}</td>
                            <td>{{$item->observacionesSup}}</td>
                            <td>
                                <form action="{{url('suplementocm/'.$item->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
    <script type="text/javascript">
        $('#datepicker2').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
    <script type="text/javascript">
        $('#datepicker3').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
    <script type="text/javascript">
        $('#datepicker4').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
