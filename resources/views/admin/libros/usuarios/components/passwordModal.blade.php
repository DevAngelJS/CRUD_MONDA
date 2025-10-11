<!-- MODAL DE CAMBIAR CONTRASEÑA USUARIO -->
<div class="modal fade" id="passwordUserModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="passwordUserModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="passwordUserModalLabel{{ $usuario->id }}">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="passwordForm" action="{{ route('admin.libros.contraseña.update', $usuario->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password_{{ $usuario->id }}">Nueva contraseña</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password_{{ $usuario->id }}" name="password" placeholder="Ingrese la contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation_{{ $usuario->id }}">Confirmar contraseña</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password_confirmation_{{ $usuario->id }}" name="password_confirmation" placeholder="Repita la contraseña">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
