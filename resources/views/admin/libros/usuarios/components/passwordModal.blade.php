<div class="card card-outline card-info mt-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-key"></i> <b>Cambiar Contraseña</b></h3>
    </div>

    <form id="passwordUserForm" method="POST">
        @csrf

        <div class="card-body">
            <!-- Contraseña Actual -->
            <div class="form-group">
                <label for="pwd_current_password">Contraseña Actual</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="pwd_current_password" name="current_password"
                        required placeholder="Ingrese su contraseña actual">
                </div>
            </div>

            <!-- Nueva Contraseña -->
            <div class="form-group">
                <label for="pwd_password">Nueva Contraseña</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="pwd_password" name="password" required
                        minlength="6" placeholder="Ingrese la nueva contraseña">
                </div>
            </div>

            <!-- Confirmar Nueva Contraseña -->
            <div class="form-group">
                <label for="pwd_password_confirmation">Confirmar Nueva Contraseña</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="pwd_password_confirmation"
                        name="password_confirmation" required minlength="6" placeholder="Confirme la nueva contraseña">
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-secondary btn-volver" style="margin-right: 5px;">Volver</button>
            <button type="submit" class="btn btn-info text-white">
                <i class="fas fa-save"></i> Actualizar Contraseña
            </button>
        </div>
    </form>
</div>
