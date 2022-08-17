<form action="{{ url('indicador', $indicador->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar este Indicador ?</h5>
        <h1 class="text-center">{{$indicador->desc}}</h1>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar esta indicador</button>
    </div>
</form>
