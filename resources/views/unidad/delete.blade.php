<form action="{{ url('unidad', $unidad->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar esta Unidad de medida ?</h5>
        <h1 class="text-center">{{$unidad->desc}}</h1>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar esta Unidad de medida</button>
    </div>
</form>
