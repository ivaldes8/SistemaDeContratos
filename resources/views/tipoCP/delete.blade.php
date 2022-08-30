<form action="{{ url('tipocp', $tipo->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar este tipo ?</h5>
        <h1 class="text-center">{{$tipo->nombre}}</h1>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar este tipo</button>
    </div>
</form>
