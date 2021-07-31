@extends('layouts.frontend')

@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap3/bootstrap.min.css') }}">
<div class=" mt-3">
    <div class="justify-content-center">
        <div class="container">

        @if (session('status'))
            <div class="mb-3 alert alert-success">{{session('status')}}</div>
        @endif
        @if (count($errors) > 0)
            <ul class="alert alert-danger pl-5 mb-3">
	            @foreach($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
            </ul>
        @endif
            <div class="card">
                <div class="card-header">
                    <h4>Adicionar Contratos Específico
                    <a href="{{url('contratos_especificos')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('contratos_especificos')}}" method="POST">
                        @csrf
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Datos del Contrato Específico</a></li>
                            <li><a data-toggle="tab" href="#menu1">Servicios</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <br/>
                                <div class="row" style="margin-left: 3%; margin-right: 3%">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="">No.Contrato:</label>
                                            <select class="col-8" style="border: solid 1px;" id="objeto" name="noContrato">
                                                    <option value = '{{$CM->id}}'>{{$CM->noContrato}}</option>
                                            </select>
                                            <p class="mt-3">Objeto del Contrato: {{$CM->objeto}}</p>
                                            <p>Organismo: {{$CM->organismos->nombreO}}</p>
                                            <p>Entidad: {{$CM->cliente->nombre}}</p>
                                            <p>No.Contrato Específico: Autogenerable</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Observaciones:</label>
                                            <textarea name="observaciones" class="form-control" id="" cols="15" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label>Fecha de firma:</label>
                                            <div class='input-group'>
                                                <input type='text' class="@error('fechaIni') is-invalid @enderror form-control" id="datepicker"  name="fechaIni" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de vencimiento:</label>
                                            <div class='input-group'>
                                                <input type='text' class="@error('fechaEnd') is-invalid @enderror form-control" id="datepicker2"  name="fechaEnd" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Nombre del Prestador:</label>
                                            <input type="text" class="@error('ejecutorName') is-invalid @enderror form-control" name="ejecutorName">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Nombre del Cliente:</label>
                                            <input type="text" class="@error('clienteName') is-invalid @enderror form-control" name="clienteName">
                                        </div>
                                        <div class="form-group">
                                            <label>Monto:</label>
                                            <input type="number"  step="0.001" class="@error('monto') is-invalid @enderror form-control" name="monto">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Área:</label>
                                            <select class="col-8" style="border: solid 1px;" name="area">
                                            @foreach ( $area as $item )
                                                <option value = '{{$item->idarea}}' selected>{{$item->Expr4}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="estado">Estado:</label>
                                            <select name="estado" id="estado" class="col-8">
                                                <option>Sin Comenzar</option>
                                                <option>En Proceso</option>
                                                <option>Terminado</option>
                                                <option>Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-9">
                                        <h3>Seleccione uno o varios servicios</h3>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary mt-4" type="submit">Crear</button>
                                    </div>
                                </div>
                              <div class="row">
                                  <div class="col-2">
                                    <input id="cod" type="text" class="form-control" placeholder="Cod.Servicio">
                                  </div>
                                  <div class="col-2">
                                    <input id="service" type="text" class="form-control col-3" placeholder="Nombre del Servicio">
                                  </div>
                                  <div class="col-5">
                                    <select id="area" class="col-6 form-control">
                                        <option value="@" selected>Área no seleccionada</option>
                                        @foreach ($area as $item)
                                        <option value="{{$item->idarea}}">{{$item->Expr4}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-3">
                                    <a id="search" class="btn btn-sm btn-primary ">Buscar</a>      
                                  </div>
                              </div>
                              <hr/>
                              <div class="row">
                                  <div class="col-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Código</th>
                                                <th>Servicio</th>
                                                <th>Área</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tBody">
                                        @for ($i = 0; $i < count($servicios); $i++)
                                            <tr>
                                                <td><input type="checkbox" name = "services[]" value = "{{$servicios[$i]->idservicio}}"></td>
                                                <td>{{$servicios[$i]->codigo}}</td>
                                                <td>{{$servicios[$i]->Expr3}}</td>
                                                @foreach ($entidadAS as $item2)
                                                    @if ($servicios[$i]->idservicio == $item2->idServicioS)
                                                        @if ($item2->areas)
                                                            <td>{{$item2->areas->Expr4}}</td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </tr> 
                                        @endfor
                                        </tbody>
                                    </table>
                                  </div>
                              </div>
                            </div>
                          </div>
                        
                        
                    </form>
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
                    <script type=text/javascript>
                        $('#search').click(function(){
                            var cod = $('#cod').val();
                            var serv = $('#service').val();
                            var area = $('#area').val();
                            //$("#tBody").empty();
                            console.log(cod);
                            if(!cod){
                                cod = "@"
                            }
                            if(!serv){
                                serv = "@"
                            }
                            if(!area){
                               area = "@"
                            }
                            if(cod || serv || area){
                                $.ajax({
                                    type:"GET",
                                    url:"{{url('filterService')}}/"+cod+'/serv/'+serv+'/area/'+area,
                                    success:function(res){
                                        if(res){
                                            console.log(res,"res")
                                            $("#tBody").empty();
                                            for (let index = 0; index < res.length; index++) {
                                                $("#tBody").append(
                                                    '<tr><td><input type="checkbox" name = "services[]" value = "'+res[index].idservicio+'"></td><td>'+res[index].codigo+'</td><td>'+res[index].Expr3+'</td><td>'+res[index].Expr4+'</td></tr>'
                                                )
                                            }
                                            /*$("#tBody").empty();
                                            $.each(res,function(key,value){
                                            $("#tBody").append('<option value="'+key+'">'+value+'</option>');
                                            });*/
                                        }
                                    }
                                });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
