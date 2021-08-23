@extends('layouts.frontend')

@section('content')

<div class="mt-3" style="margin-right: 2%; margin-left: 2%">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    <form action="{{ url('sup_ce_search') }}"  method="GET">
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
                                <th style="width: 20px;">No.Suplemento</th>
                                <th style="width: 120px;">Objeto</th>
                                <th style="width: 120px;">Ejecutor</th>
                                <th style="width: 60px;">Fecha de Firma</th>
                                <th style="width: 60px;">Fecha de Cierre</th>
                                <th style="width: 120px;">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($Sup as $item)
                            <tr style="font-size: 70%; {{\Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->lte($now) ? 'background-color: red' : ''}}"
                                class = "{{ \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->gte($now) 
                                            &&
                                        \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEndSup)->format('d-m-y'))->lte($ThreeDaysearly) 
                                            ? 'bg-warning' : ''}}">
                                <td><a href="{{url('suplementoce/'.$item->id.'/edit')}}">{{$item->noSupCE}}</a></td>
                                <td>
                                    @foreach ($objetos as $objeto)
                                        @if ($objeto->idSupCE == $item->id)
                                            /{{$objeto->ObjCESups->ObjetoSuplementoCE}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$item->ejecutorSup}}</td>
                                <td>{{$item->fechaIniSup}}</td>
                                <td>{{$item->fechaEndSup}}</td>
                                <td>{{$item->observacionesSup}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($links)
                    {{$Sup->links()}}   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
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
    <script type=text/javascript>
        organismo = 1;
        $('#organismo').change(function(){
        var organismoID = $(this).val();
        organismo = organismoID;
        if(organismoID){
            $.ajax({
                type:"GET",
                url:"{{url('getGrupoEntidad')}}?organismo_id="+organismoID,
                success:function(res){
                    if(res){
                        $("#grupo").empty();
                        $("#client").empty();
                        $("#grupo").append('<option>Seleccione un grupo</option>');
                        $.each(res,function(key,value){
                            $("#grupo").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#grupo").empty();
                    }
                }
            });
        }else{
            $("#grupo").empty();
            $("#client").empty();
        }
        });
        $('#grupo').on('change',function(){
        var grupoID = $(this).val();
        if(grupoID){
            $.ajax({
                type:"GET",
                url:"{{url('getClientEntidad')}}/"+grupoID+'/org/'+ organismo,
                 success:function(res){
                    if(res){
                        $("#client").empty();
                        $("#client").append('<option>Seleccione un Cliente</option>');
                        $.each(res,function(key,value){
                        $("#client").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#client").empty();
                    }
                }
            });
        }else{
            $("#client").empty();
        }

        });
    </script>
@endsection
