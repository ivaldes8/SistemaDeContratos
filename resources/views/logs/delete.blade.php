<form action="{{ url('logs') }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Seguro que desea eliminar todos los Logs ?</h5>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Si, Eliminar este Grupo</button>
    </div>
</form>
