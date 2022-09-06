<form action="{{ url('ce', $ce->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar este Contrato Específico ?</h5>
        <h1 class="text-center">{{ $ce->noCE }}</h1>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Si, Eliminar este Contrato Específico</button>
    </div>
</form>
