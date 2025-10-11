<!-- MODAL DE CREAR USUARIO -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="createUserModalLabel">Crear usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createUserForm" action="{{ route('admin.libros.usuarios.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="alert text-danger p-0 m-0">
                                <b>{{ 'Este campo es obligatorio.' }}</b>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="alert text-danger p-0 m-0">
                                <b>{{ $message }}</b>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
                        </div>
                        @error('password')
                            <div class="alert text-danger p-0 m-0">
                                <b>{{ $message }}</b>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text inline-block"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repita la contraseña">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
