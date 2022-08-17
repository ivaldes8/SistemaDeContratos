@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
            @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                      {{$producto === "none" ? 'Crear Producto' : 'Editar Producto'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('producto')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($producto === "none")
                <form action="{{url('producto')}}" method="POST">
            @else
                <form action="{{url('producto/'.$producto->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Descripción:</label>
                        <input type="text" name="desc" class="form-control" value="{{ $producto !== 'none' ? $producto->desc : '' }}">
                        @if ($errors->has('desc'))
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Actividades Industriales:</label>
                        <select name="actividades[]" multiple="multiple" class="form-select actSelect">
                            @foreach ($actividad as $item)
                                <option {{ $producto !== 'none' && !!$producto->actividades->where('id', $item->id)->first() ? 'selected' : '' }} value="{{$item->id}}">{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('actividades'))
                            <span class="text-danger">{{ $errors->first('actividades') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">CPCU:</label>
                        <select name="cpcus[]" multiple="multiple" class="form-select cpcuSelect">
                            @foreach ($cpcu as $item)
                                <option {{ $producto !== 'none' && !!$producto->cpcus->where('id', $item->id)->first() ? 'selected' : '' }} value="{{$item->id}}">{{$item->codigo}}/{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('cpcus'))
                            <span class="text-danger">{{ $errors->first('cpcus') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">SACLAP:</label>
                        <select name="saclaps[]" multiple="multiple" class="form-select saclapSelect">
                            @foreach ($saclap as $item)
                                <option {{ $producto !== 'none' && !!$producto->saclaps->where('id', $item->id)->first() ? 'selected' : '' }} value="{{$item->id}}">{{$item->codigo}}/{{$item->desc}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('saclaps'))
                            <span class="text-danger">{{ $errors->first('saclaps') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$producto === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.cpcuSelect').select2();
        });
        $(document).ready(function() {
            $('.saclapSelect').select2();
        });
        $(document).ready(function() {
            $('.actSelect').select2();
        });
    </script>
@endsection

