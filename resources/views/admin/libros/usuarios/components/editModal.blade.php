<!-- MODAL DE EDITAR USUARIO -->
<div class="modal fade" id="editUserModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="editUserModalLabel{{ $usuario->id }}">Editar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="editUserForm" action="{{ route('admin.libros.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_{{ $usuario->id }}">Nombre completo</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name_{{ $usuario->id }}" name="name" value="{{ $usuario->name }}" placeholder="Ingrese el nombre">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email_{{ $usuario->id }}">Email</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email_{{ $usuario->id }}" name="email" value="{{ $usuario->email }}" placeholder="Ingrese el email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
