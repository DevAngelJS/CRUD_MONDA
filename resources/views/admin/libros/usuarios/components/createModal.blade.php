<!-- CARD DE CREAR USUARIO -->
<div id="createUserModal" class="card card-outline card-info mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-plus"></i> <b>Crear Usuario</b>
        </h3>
    </div>

    <form id="createUserForm" action="{{ route('admin.libros.usuarios.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="grid-form">
                <!-- Perffil -->
                <div class="form-group">
                    <label for="perfil">Perfil</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                        </div>
                        <select class="form-control" id="perfil" name="perfil">
                            <option value="" disabled selected>Seleccione un perfil</option>
                            <option value="administrador" {{ old('perfil') == 'administrador' ? 'selected' : '' }}>
                                Administrador</option>
                            <option value="estudiante" {{ old('perfil') == 'estudiante' ? 'selected' : '' }}>Estudiante
                            </option>
                            <option value="bibliotecario" {{ old('perfil') == 'bibliotecario' ? 'selected' : '' }}>
                                Bibliotecario</option>
                        </select>
                    </div>
                    @error('perfil')
                        <div class="alert text-danger p-0 m-0"><b>Este campo es obligatorio.</b></div>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text inline-block"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Ingrese el nombre" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="alert text-danger p-0 m-0"><b>Este campo es obligatorio.</b></div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text inline-block"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Ingrese el email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="alert text-danger p-0 m-0"><b>{{ $message }}</b></div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text inline-block"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Ingrese la contraseña">
                    </div>
                    @error('password')
                        <div class="alert text-danger p-0 m-0"><b>{{ $message }}</b></div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text inline-block"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Repita la contraseña">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-secondary btn-volver" style="margin-right: 5px">Volver</button>
            <button type="submit" class="btn btn-primary">Crear</button>
        </div>
    </form>
</div>




@section('css')
    <style>
        /* Elimina el fondo bloqueador del modal */
        .modal-backdrop {
            display: none !important;
        }

        /* Permite clics a través del área fuera de la ventana */
        .modal {
            pointer-events: none;
            /* No bloquea clics */
        }

        /* Pero sí permite clics dentro del contenido del modal */
        .modal-dialog,
        .modal-content {
            pointer-events: auto;
            /* Reactiva clics solo dentro */
        }
    </style>
@endsection
