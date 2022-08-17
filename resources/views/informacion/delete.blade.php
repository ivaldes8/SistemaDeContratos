<form action="{{ url('informacion', $informacion->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar esta información ?</h5>
        <h3 class="text-center">{{$informacion->indicador->desc}} - {{$informacion->date}} - {{$informacion->value}}</h3>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar esta información</button>
    </div>
</form>
