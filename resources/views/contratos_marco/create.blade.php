@extends('layouts.frontend')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">

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
                    <h4>Adicionar Contratos Marco
                    <a href="{{url('contratos_marco')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('contratos_marco')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">No.Contrato</label>
                            <input type="number" name="codigo" disabled class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Objeto del contrato:</label>
                            <select class="col-8" style="border: solid 1px;" id="objeto" name="objeto">
                            @foreach ( $objeto as $item )
                                <option value = '{{$item->nombre}}'>{{$item->nombre}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="state">Organismo:</label>
                            <select id="organismo" name="organismo" class="@error('organismo') is-invalid @enderror col-8">
                                <option value="" selected disabled>Seleccione un Organismo:</option>
                                @foreach($organismos as $organismo)
                                <option value="{{$organismo->id}}" > {{$organismo->nombreO}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="grupo">Seleccione un Grupo:</label>
                            <select name="grupo" id="grupo" class="col-8">
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="client">Cliente:</label>
                            <select name="cliente" id="client" class="col-8"></select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="estado">Estado:</label>
                            <select name="estado" id="estado" class="col-8">
                                <option value="Vigente">Vigente</option>
                                <option value="Vencido">Vencido</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label>Fecha de firma:</label>
                            <div class='input-group'>
                                <input type='text' class="form-control" id="datepicker"  name="fechaIni" />
                                <span  class="btn btn-primary  disabled">
                                <svg style="width: 100%; margin-left: -140px;margin-top: -20px;margin-bottom: -20px; margin-right: -140px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M400 64h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V160h352v298c0 3.3-2.7 6-6 6z"/></svg>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        <label>Fecha de vencimiento:</label>
                            <div class='input-group'>
                                <input type='text' class="form-control" id="datepicker2"  name="fechaEnd" />
                                <span  class="btn btn-primary  disabled">
                                <svg style="width: 100%; margin-left: -140px;margin-top: -20px;margin-bottom: -20px; margin-right: -140px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M400 64h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V160h352v298c0 3.3-2.7 6-6 6z"/></svg>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                                <label>Nombre del Contacto:</label>
                                <input type="text" class="@error('nombreContacto') is-invalid @enderror form-control" name="nombreContacto">
                        </div>
                        <div class="form-group">
                                <label>Email del Contacto:</label>
                                <input type="text" class="@error('emailContacto') is-invalid @enderror form-control" name="emailContacto">
                        </div>
                        <div class="form-group">
                                <label>Elaborado por:</label>
                                <input type="text" class="@error('elaboradoPor') is-invalid @enderror form-control" name="elaboradoPor">
                        </div>
                        <div class="form-group">
                                <label>Observaciones:</label>
                                <textarea name="observaciones" class="form-control" id="" cols="15" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Crear</button>
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
                        $('#datepicker').change(function(){
                          let aux = $(this).val().split('-')
                          let aux2 = Number(aux[2]) + 5
                          $('#datepicker2').datepicker('setDate', aux[0]+ '-' + aux[1] + '-' + aux2);
                        });
                    </script>
                     <script type="text/javascript">
                        $('#datepicker2').datepicker({
                            autoclose: true,
                            format: 'dd-mm-yyyy',
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
