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
                    <h4>Adicionar Suplemento de Contrato Marco
                    <a href="{{url('suplementocm')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('suplementocm')}}" method="POST">
                        @csrf
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Datos del Suplemento</a></li>
                            <li><a data-toggle="tab" href="#menu1">Objetos</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <br/>
                                <div class="row" style="margin-left: 3%; margin-right: 3%">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="">No.Contrato:</label>
                                            <select class="col-8" style="border: solid 1px;" id="objeto" name="noContrato">
                                                    <option value = '{{$CM->id}}'>{{$CM->noContrato}}</option>
                                            </select>
                                            <p class="mt-3">Objeto del Contrato: {{$CM->objeto}}</p>
                                            <p>Organismo: {{$CM->organismos->nombreO}}</p>
                                            <p>Entidad: {{$CM->cliente->nombre}}</p>
                                            <p>No.Suplemento: Autogenerable</p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de firma del Contrato Marco:</label>
                                            <div class='input-group'>
                                                <input type='text' class="form-control" readonly value="{{$CM->fechaIni}}"  name="fechaIniCM" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de firma:</label>
                                            <div class='input-group'>
                                                <input type='text' class="@error('fecha') is-invalid @enderror form-control" id="datepicker"  name="fecha" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de vencimiento del Contrato Marco:</label>
                                            <div class='input-group'>
                                                <input type='text' class="form-control" readonly  value="{{$CM->fechaEnd}}" name="fechaEndCM" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de cierre:</label>
                                            <div class='input-group'>
                                                <input type='text' class="@error('fechaEnd') is-invalid @enderror form-control" id="datepicker2"  name="fechaEnd" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Nombre del Ejecutor:</label>
                                            <input type="text" class="@error('ejecutor') is-invalid @enderror form-control" name="ejecutor">
                                        </div>
                                        <div class="form-group  mb-3">
                                            <label>Observaciones:</label>
                                            <textarea name="observaciones" class="form-control" id="" cols="15" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-9">
                                        <h3>Seleccione uno o varios Objetos</h3>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary mt-4" type="submit">Crear</button>
                                    </div>
                                </div>
                              <div class="row">
                                  <div class="col-9">
                                    <input id="obj" type="text" class="form-control col-3" placeholder="Nombre del Objeto">
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
                                                <th>Objeto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tBody">
                                        @for ($i = 0; $i < count($obj); $i++)
                                            <tr>
                                                <td><input type="checkbox" name = "objs[]" value = "{{$obj[$i]->id}}"></td>
                                                <td>{{$obj[$i]->ObjetoSuplementoCM}}</td>
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
                            console.log('search')
                            var obj = $('#obj').val();
                            if(!obj){
                                cod = "@"
                            }
                            if(obj){
                                $.ajax({
                                    type:"GET",
                                    url:"{{url('filterObj')}}/"+obj,
                                    success:function(res){
                                        if(res){
                                            console.log(res,"res")
                                            $("#tBody").empty();
                                            for (let index = 0; index < res.length; index++) {
                                                $("#tBody").append(
                                                    '<tr><td><input type="checkbox" name = "objs[]" value = "'+res[index].id+'"></td><td>'+res[index].ObjetoSuplementoCM+'</td></tr>'  
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
