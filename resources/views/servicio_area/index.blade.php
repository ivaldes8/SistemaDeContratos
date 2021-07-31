 @extends('layouts.frontend')

@section('content')

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            Listado de Servicios
                        </div>
                    </div>
                    <br/>
                    <form action="{{ url('servicioAreaSearch') }}"  method="GET">
                        <div class="row">
                            <div class="col-3">
                                Código:<input type="text" class="form-control" name="cod"/>
                            </div>
                            <div class="col-3">
                                Servicio:<input type="text" class="form-control" name="serv"/>
                            </div>
                            <div class="col-3">
                                Área:
                                <select name="area" class="col-8 form-control">
                                    <option value="@">Ningún Área seleccionada</option>
                                    @foreach ( $area as $item )
                                    <option value="{{$item->idarea}}">{{$item->Expr4}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary mt-4" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Servicio</th>
                                <th>Área</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($servicios as $item)
                            <tr>
                                <td><a href="{{url('servicio_area/'.$item->idservicio.'/edit')}}">{{$item->codigo}}</a></td>
                                <td>{{$item->Expr3}}</td>
                                @foreach ($entidadAS as $item2)
                                    @if ($item->idservicio == $item2->idServicioS)
                                        @if ($item2->areas)
                                            <td>{{$item2->areas->Expr4}}</td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($links)
                    {{$servicios->links()}}   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
